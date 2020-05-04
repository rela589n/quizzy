<?php


namespace App\Lib\Parsers;


class TestTxtParser extends TestParser
{
    private $fileName;

    /**
     * TestTxtParser constructor.
     * @param TestSanitizer $sanitizer
     * @param string $fileName
     */
    public function __construct(TestSanitizer $sanitizer, string $fileName)
    {
        parent::__construct($sanitizer);
        $this->fileName = $fileName;
    }

    /**
     * @throws \App\Exceptions\FileUnopenableException
     */
    protected function getTextLines()
    {
        foreach (next_line($this->fileName) as $item) {
            yield $item;
        }
    }
}
