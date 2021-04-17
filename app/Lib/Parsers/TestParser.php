<?php


namespace App\Lib\Parsers;


use App\Lib\Parsers\Block\ParsedQuestionBlock;
use RuntimeException;

abstract class TestParser
{
    protected const STATUS_QUESTION = 1;
    protected const STATUS_OPTION = 2;

    protected int $status = self::STATUS_QUESTION;

    /** @var ParsedQuestionBlock[] */
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
                $this->appendQuestion($question);

                break;

            case self::STATUS_OPTION:
                [$option, $isRight, $reason] = $this->sanitizer->sanitizeOptionText($input);
                $this->appendOption($option, $isRight, $reason);

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

    protected function appendQuestion($question): void
    {
        $this->parsedQuestions[] = ParsedQuestionBlock::make()->withQuestionText($question);
    }

    protected function appendOption(string $text, bool $isRight, $correctnessReason): void
    {
        $this->parsedQuestions[count($this->parsedQuestions) - 1]
            ->withAnswerOption($text, $isRight, $correctnessReason);
    }
}
