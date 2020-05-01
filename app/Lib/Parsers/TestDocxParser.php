<?php


namespace App\Lib\Parsers;


use App\Exceptions\NullPointerException;

class TestDocxParser extends TestParser
{
    protected $phpWord;

    public function __construct(TestSanitizer $sanitizer, \PhpOffice\PhpWord\PhpWord $phpWord = null)
    {
        parent::__construct($sanitizer);
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
