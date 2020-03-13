<?php

namespace App\Lib\Statements;

use App\Lib\Statements\FilePathGenerators\FilePathGenerator;
use App\Lib\TestResultsEvaluator;
use App\Lib\Words\WordsManager;
use App\Models\TestResult;
use PhpOffice\PhpWord\TemplateProcessor;

abstract class StatementsGenerator
{
    /**
     * @var TestResult
     */
    protected $result;

    /**
     * @var TestResultsEvaluator
     */
    protected $resultEvaluator;

    /**
     * @var WordsManager
     */
    protected $wordsManager;

    /**
     * @var FilePathGenerator
     */
    protected $filePathGenerator;


    public function __construct(WordsManager $wordsManager, FilePathGenerator $filePathGenerator)
    {
        $this->wordsManager = $wordsManager;
        $this->filePathGenerator = $filePathGenerator;
    }

    /**
     * @param TestResult $result
     */
    public function setResult(TestResult $result): void
    {
        $this->result = $result;
        $this->filePathGenerator->setResult($this->result);
        $this->resultEvaluator = $this->result->getResultEvaluator();
    }

    /**
     * @return string path to generated statement file
     * @throws \App\Exceptions\NullPointerException
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function generate()
    {
        $templateProcessor = new TemplateProcessor(resource_path($this->templateResourcePath()));
        $this->doGenerate($templateProcessor);

        $filePath = $this->filePathGenerator->generate();
        $templateProcessor->saveAs($filePath);

        return $filePath;
    }

    abstract protected function doGenerate(TemplateProcessor $templateProcessor);
    abstract protected function templateResourcePath() : string;
}
