<?php


namespace App\Lib\Parsers;


use RuntimeException;

abstract class TestParser
{
    protected const STATUS_QUESTION = 1;
    protected const STATUS_OPTION = 2;

    protected int $status = self::STATUS_QUESTION;
    protected array $parsedQuestions = [];
    protected TestSanitizer $sanitizer;

    public function __construct(TestSanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    public function getParsedQuestions(): array
    {
        return $this->parsedQuestions;
    }

    public function parse(): void
    {
        $this->status = self::STATUS_QUESTION;

        foreach ($this->getTextLines() as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            $line = $this->sanitizer->sanitizeEncoding($line);

            $this->status = $this->identifyStatus($line);
            $this->handleText($line);
        }
    }

    abstract protected function getTextLines();

    protected function handleText(string $input): void
    {
        switch ($this->status) {
            case self::STATUS_QUESTION:
                $question = $this->sanitizer->sanitizeQuestionText($input);
                $this->appendQuestion($question, []);

                break;

            case self::STATUS_OPTION:
                [$option, $isRight] = $this->sanitizer->sanitizeOptionText($input);
                $this->appendOption(count($this->parsedQuestions) - 1, $option, $isRight);

                break;

            default:
                throw new RuntimeException("Undefined status!");
        }
    }

    protected function identifyStatus(string $line): int
    {
        if (preg_match('/^\d+\s?[).]/', $line)) {
            return self::STATUS_OPTION;
        }

        return self::STATUS_QUESTION;
    }

    protected function appendQuestion($question, $insertOptions): void
    {
        $this->parsedQuestions[] = [
            'question'       => $question,
            'insert_options' => $insertOptions,
        ];
    }

    protected function appendOption($questionIndex, $text, $isRight): void
    {
        $this->parsedQuestions[$questionIndex]['insert_options'][] = [
            'text'     => $text,
            'is_right' => $isRight,
        ];
    }
}
