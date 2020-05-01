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

                $this->status = self::STATUS_OPTION;
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

}
