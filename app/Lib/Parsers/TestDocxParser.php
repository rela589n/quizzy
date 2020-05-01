<?php


namespace App\Lib\Parsers;


use App\Exceptions\NullPointerException;

class TestDocxParser
{
    protected $phpWord;
    protected $parsedQuestions = [];

    private const STATUS_QUESTION = 1;
    private const STATUS_OPTION = 2;

    protected $status = self::STATUS_QUESTION;

    private const QUESTION_INDICATORS = ['Питання', 'Запитання'];

    /**
     * @return array
     */
    public function getParsedQuestions(): array
    {
        return $this->parsedQuestions;
    }

    public function __construct(\PhpOffice\PhpWord\PhpWord $phpWord = null)
    {
        $this->phpWord = $phpWord;
    }

    /**
     * @param \PhpOffice\PhpWord\PhpWord $phpWord
     */
    public function setPhpWord(\PhpOffice\PhpWord\PhpWord $phpWord): void
    {
        $this->phpWord = $phpWord;
    }

    /**
     * @throws NullPointerException
     */
    public function parse(): void
    {
        if ($this->phpWord === null) {
            throw new NullPointerException('PhpWord is required to parse docx document.');
        }

        foreach ($this->phpWord->getSections() as $section) {
            $this->parseSection($section);
        }
    }

    /**
     * @param \PhpOffice\PhpWord\Element\Section $section
     */
    protected function parseSection(\PhpOffice\PhpWord\Element\Section $section): void
    {
        $this->status = self::STATUS_QUESTION;

        foreach ($section->getElements() as $element) {

            if ($element instanceof \PhpOffice\PhpWord\Element\TextBreak) {
                // new question starts

                $this->status = self::STATUS_QUESTION;

                continue;
            }

            if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {

                $line = $this->implodeElements($element->getElements());

                $this->handleText($line);
            }

        }
    }

    /**
     * @param string $input
     */
    protected function handleText(string $input): void
    {
        switch ($this->status) {
            case self::STATUS_QUESTION:
                $question = $this->sanitizeQuestionText($input);

                $this->parsedQuestions[] = [
                    'question'       => $question,
                    'insert_options' => [],
                ];

                $this->status = self::STATUS_OPTION;
                break;

            case self::STATUS_OPTION:
                [$option, $isRight] = $this->sanitizeOptionText($input);


                $this->parsedQuestions[count($this->parsedQuestions) - 1]['insert_options'][] = [
                    'text'     => $option,
                    'is_right' => $isRight,
                ];

                break;

            default:
                throw new \RuntimeException("Undefined status!");
        }
    }

    /**
     * @param string $text
     * @return string
     */
    protected function sanitizeQuestionText(string $text)
    {
        $text = $this->sanitizeMultipleSpaces($text);

        foreach (self::QUESTION_INDICATORS as $indicator) {
            $text = preg_replace("/^({$indicator})?[\s#№\d]*[.)]*/", '', $text);
        }

        return rtrim(ltrim($text), ':.?') . '?';
    }

    /**
     * @param string $text
     * @return array
     */
    protected function sanitizeOptionText(string $text)
    {
        $text = $this->sanitizeMultipleSpaces($text);

        $text = preg_replace('/^\d+[.)\s]*/', '', $text);
        $result = preg_replace('/\s*\*$/', '', $text);

        $isRight = $result !== $text;
        return [$result, $isRight];
    }

    /**
     * @param string $text
     * @return string
     */
    protected function sanitizeMultipleSpaces(string $text)
    {
        return preg_replace('/\s+/', ' ', trim($text));
    }

    /**
     * @param \PhpOffice\PhpWord\Element\AbstractElement[] $elements
     * @return string
     */
    protected function implodeElements(array $elements): string
    {
        $result = '';

        foreach ($elements as $element) {
            if (!method_exists($element, 'getText')) {
                $result .= ' ';
                continue;
            }

            $result .= $element->getText();
        }

        return $result;
    }
}
