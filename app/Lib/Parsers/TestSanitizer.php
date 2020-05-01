<?php


namespace App\Lib\Parsers;


class TestSanitizer
{
    private const QUESTION_INDICATORS = ['Питання', 'Запитання'];

    /**
     * @param string $text
     * @return string
     */
    public function sanitizeQuestionText(string $text)
    {
        $text = $this->sanitizeMultipleSpaces($text);

        foreach (self::QUESTION_INDICATORS as $indicator) {
            $text = preg_replace("/^({$indicator})?[\s\d#№]*[.)]*/i", '', $text);
        }

        return rtrim(ltrim($text), " \t\n\r\0\x0B:.?") . '?';
    }

    /**
     * @param string $text
     * @return array
     */
    public function sanitizeOptionText(string $text)
    {
        $text = $this->sanitizeMultipleSpaces($text);

        $text = preg_replace('/^\d+[\s.)]*/', '', $text);
        $result = preg_replace('/\s*\*$/', '', $text);

        $isRight = $result !== $text;
        return [$result, $isRight];
    }

    /**
     * @param string $text
     * @return string
     */
    public function sanitizeMultipleSpaces(string $text)
    {
        return preg_replace('/\s+/', ' ', trim($text));
    }
}
