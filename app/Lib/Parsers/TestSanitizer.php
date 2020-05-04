<?php


namespace App\Lib\Parsers;

use Onnov\DetectEncoding\EncodingDetector;

class TestSanitizer
{
    private const QUESTION_INDICATORS = ['Питання', 'Запитання'];

    protected $encodingDetector;
    protected $encoding;

    public function __construct(EncodingDetector $encodingDetector)
    {
        $this->encodingDetector = $encodingDetector;
    }

    public function sanitizeEncoding(string $text): string
    {
        return mb_convert_encoding(
            $text,
            'UTF-8',
            singleVar($this->encoding, function () use ($text) {
                return $this->encodingDetector->getEncoding($text);
            })
        );
    }

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

        return preg_replace('/\s*\.$/', '?', ltrim($text));
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
