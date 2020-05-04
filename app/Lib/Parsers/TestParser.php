<?php


namespace App\Lib\Parsers;


abstract class TestParser
{
    protected const STATUS_QUESTION = 1;
    protected const STATUS_OPTION = 2;

    protected $status = self::STATUS_QUESTION;
    protected $parsedQuestions = [];
    protected $sanitizer;

    public function __construct(TestSanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    /**
     * @return array
     */
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

    /**
     * @param string $input
     */
    protected function handleText(string $input): void
    {
        switch ($this->status) {
            case self::STATUS_QUESTION:
                $question = $this->sanitizer->sanitizeQuestionText($input);

                $this->parsedQuestions[] = [
                    'question'       => $question,
                    'insert_options' => [],
                ];

                break;

            case self::STATUS_OPTION:
                [$option, $isRight] = $this->sanitizer->sanitizeOptionText($input);


                $this->parsedQuestions[count($this->parsedQuestions) - 1]['insert_options'][] = [
                    'text'     => $option,
                    'is_right' => $isRight,
                ];

                break;

            default:
                throw new \RuntimeException("Undefined status!");
        }
    }

    protected function identifyStatus(string $line)
    {
        if (preg_match('/^\d+\s?[).]/', $line)) {
            return self::STATUS_OPTION;
        }

        return self::STATUS_QUESTION;
    }
}
