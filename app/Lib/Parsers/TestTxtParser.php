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
    public function parse(): void
    {
        $this->status = self::STATUS_QUESTION;

        foreach (next_line($this->fileName) as $line) {
            $line = trim($line);

            if ($line === '') {
                $this->status = self::STATUS_QUESTION;
                continue;
            }

            $this->handleText($line);
        }
    }
}
