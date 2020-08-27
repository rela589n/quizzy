<?php


namespace App\Lib\Parsers;


use App\Exceptions\NullPointerException;
use Generator;
use PhpOffice\PhpWord\Element\AbstractElement;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\PhpWord;

class TestDocxParser extends TestParser
{
    protected ?PhpWord $phpWord;

    public function __construct(TestSanitizer $sanitizer, PhpWord $phpWord = null)
    {
        parent::__construct($sanitizer);
        $this->phpWord = $phpWord;
    }

    public function setPhpWord(PhpWord $phpWord): void
    {
        $this->phpWord = $phpWord;
    }

    /**
     * @return Generator|null
     * @throws NullPointerException
     */
    protected function getTextLines(): ?Generator
    {
        if ($this->phpWord === null) {
            throw new NullPointerException('PhpWord is required to parse docx document.');
        }

        foreach ($this->phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if ($element instanceof TextRun) {
                    yield $this->implodeElements($element->getElements());
                }
            }
        }
    }

    /**
     * @param  AbstractElement[]  $elements
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
