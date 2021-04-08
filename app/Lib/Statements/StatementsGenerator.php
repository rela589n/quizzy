<?php

namespace App\Lib\Statements;

use App\Lib\PHPWord\TemplateProcessor;
use App\Lib\Statements\FilePathGenerators\ResultFileNameGenerator;
use App\Lib\Words\WordsManager;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\Settings as PhpWordSettings;

abstract class StatementsGenerator
{
    protected WordsManager $wordsManager;
    protected ResultFileNameGenerator $filePathGenerator;

    public function __construct(WordsManager $wordsManager, ResultFileNameGenerator $filePathGenerator)
    {
        $this->wordsManager = $wordsManager;
        $this->filePathGenerator = $filePathGenerator;
    }

    /**
     * @return string path to generated statement file
     */
    public function generate(): string
    {
        PhpWordSettings::setOutputEscapingEnabled(true);

        $templateProcessor = new TemplateProcessor(resource_path($this->templateResourcePath()));
        $this->doGenerate($templateProcessor);

        $filePath = $this->filePathGenerator->generate();
        $templateProcessor->saveAs($filePath);

        PhpWordSettings::setOutputEscapingEnabled(false);
        return $filePath;
    }

    public function getFilePathGenerator(): ResultFileNameGenerator
    {
        return $this->filePathGenerator;
    }

    abstract protected function doGenerate(TemplateProcessor $templateProcessor) : void;
    abstract protected function templateResourcePath() : string;
}
