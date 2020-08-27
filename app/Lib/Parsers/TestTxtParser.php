<?php


namespace App\Lib\Parsers;


use App\Exceptions\FileUnopenableException;
use Generator;

class TestTxtParser extends TestParser
{
    private string $fileName;

    public function __construct(TestSanitizer $sanitizer, string $fileName)
    {
        parent::__construct($sanitizer);
        $this->fileName = $fileName;
    }

    /**
     * @throws FileUnopenableException
     */
    protected function getTextLines(): ?Generator
    {
        foreach (next_line($this->fileName) as $item) {
            yield $item;
        }
    }
}
