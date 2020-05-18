<?php

namespace App\Lib\Statements;

use App\Lib\PHPWord\TemplateProcessor;
use App\Lib\Statements\FilePathGenerators\ResultFileNameGenerator;
use App\Lib\Words\WordsManager;

abstract class StatementsGenerator
{
    /**
     * @var WordsManager
     */
    protected $wordsManager;

    /**
     * @var ResultFileNameGenerator
     */
    protected $filePathGenerator;

    /**
     * StatementsGenerator constructor.
     * @param WordsManager $wordsManager
     * @param ResultFileNameGenerator $filePathGenerator
     */
    public function __construct(WordsManager $wordsManager, ResultFileNameGenerator $filePathGenerator)
    {
        $this->wordsManager = $wordsManager;
        $this->filePathGenerator = $filePathGenerator;
    }

    /**
     * @return string path to generated statement file
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function generate()
    {
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);

        $templateProcessor = new TemplateProcessor(resource_path($this->templateResourcePath()));
        $this->doGenerate($templateProcessor);

        $filePath = $this->filePathGenerator->generate();
        $templateProcessor->saveAs($filePath);

        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(false);
        return $filePath;
    }

    abstract protected function doGenerate(TemplateProcessor $templateProcessor) : void;
    abstract protected function templateResourcePath() : string;
}
