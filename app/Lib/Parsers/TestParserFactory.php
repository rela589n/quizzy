<?php


namespace App\Lib\Parsers;


use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Foundation\Application;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpWord\IOFactory;
use RuntimeException;

class TestParserFactory
{
    private ApplicationContract $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getTextParser(UploadedFile $file): TestParser
    {
        $filePath = $file->path();
        $extension = $file->extension();

        if ('bin' === $extension) {
            $extension = $file->getClientOriginalExtension();
        }

        switch ($extension) {
            case 'docx':
            case 'doc':
                return $this->app->makeWith(
                    TestDocxParser::class,
                    [
                        'phpWord' => IOFactory::load($filePath)
                    ]
                );

            case 'txt':
                return $this->app->makeWith(
                    TestTxtParser::class,
                    [
                        'fileName' => $filePath
                    ]
                );

            default:
                throw new RuntimeException("Unknown test file type: {$extension}");
        }
    }
}
