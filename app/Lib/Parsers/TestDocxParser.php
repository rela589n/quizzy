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
     * @return \Generator
     * @throws NullPointerException
     */
    protected function getTextLines()
    {
        if ($this->phpWord === null) {
            throw new NullPointerException('PhpWord is required to parse docx document.');
        }

        foreach ($this->phpWord->getSections() as $section) {

            foreach ($section->getElements() as $element) {

                if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {

                    yield $this->implodeElements($element->getElements());

                }
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
