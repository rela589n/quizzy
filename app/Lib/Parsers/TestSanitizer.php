<?php


namespace App\Lib\Parsers;

use App\Lib\Parsers\Block\ParsedQuestionBlock;
use Onnov\DetectEncoding\EncodingDetector;

use function preg_match;

class TestSanitizer
{
    private const QUESTION_INDICATORS = ['Питання', 'Запитання'];
    private const PATTERN_CHECKBOX = '/\s*\*$/';
    private const PATTERN_RADIO = '/\s*&$/';

    protected EncodingDetector $encodingDetector;
    protected ?string $encoding = null;

    public function __construct(EncodingDetector $encodingDetector)
    {
        $this->encodingDetector = $encodingDetector;
    }

    public function sanitizeEncoding(string $text): string
    {
        return mb_convert_encoding(
            $text,
            'UTF-8',
            singleVar(
                $this->encoding,
                function () use ($text) {
                    return $this->encodingDetector->getEncoding($text);
                }
            )
        );
    }

    public function sanitizeQuestionText(string $text)
    {
        $text = $this->sanitizeMultipleSpaces($text);

        foreach (self::QUESTION_INDICATORS as $indicator) {
            $text = preg_replace("/^({$indicator})?[\s\d#№]*[.)]*/i", '', $text);
        }

        return preg_replace('/\s*\.$/', '?', ltrim($text));
    }

    /**
     * @param  string  $text
     * @return array [$result, $isRight]
     */
    public function sanitizeOptionText(string $text): array
    {
        $text = $this->sanitizeMultipleSpaces($text);

        $text = preg_replace('/^\d+[\s.)]*/', '', $text);
        $result = preg_replace(self::PATTERN_CHECKBOX, '', $text);
        $result = preg_replace(self::PATTERN_RADIO, '', $result);

        $isRight = $result !== $text;

        $reason = null;
        if ($isRight) {
            if (preg_match(self::PATTERN_CHECKBOX, $text)) {
                $reason = ParsedQuestionBlock::CORRECT_CHECKBOXED;
            } elseif (preg_match(self::PATTERN_RADIO, $text)) {
                $reason = ParsedQuestionBlock::CORRECT_RADIO;
            }
        }

        return [$result, $isRight, $reason];
    }

    public function sanitizeMultipleSpaces(string $text): string
    {
        return html_entity_decode(
            preg_replace('/\s+/', ' ', trim($text)),
            ENT_QUOTES
        );
    }
}
