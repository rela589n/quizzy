<?php


namespace App\Lib\Parsers;


use Illuminate\Foundation\Application;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpWord\IOFactory;

class TestParserFactory
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application
     */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param UploadedFile $file
     * @return TestParser
     */
    public function getTextParser(UploadedFile $file): TestParser
    {
        $filePath = $file->path();

        switch ($file->extension()) {
            case 'docx':
                return $this->app->makeWith(TestDocxParser::class, [
                    'phpWord' => IOFactory::load($filePath)
                ]);

            case 'txt':
                return $this->app->makeWith(TestTxtParser::class, [
                    'fileName' => $filePath
                ]);

            default:
                throw new \RuntimeException("Unknown test file type: {$file->extension()}");
        }
    }
}
