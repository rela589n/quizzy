<?php


namespace App\Lib\Statements\FilePathGenerators;


use App\Models\TestResult;

abstract class FilePathGenerator
{
    protected $storageDir = 'app/public/statements/';
    protected $filePrefix = 'Відомість';

    /**
     * @var TestResult
     */
    protected $result;

    public function __construct(TestResult $result)
    {
        $this->result = $result;
    }

    /**
     * @param TestResult $result
     */
    public function setResult(TestResult $result): void
    {
        $this->result = $result;
    }

    public function generate()
    {
         return storage_path(sprintf(
            '%s%s',
            $this->storageDir,
            $this->generateFileName()
        ));
    }

    abstract protected function generateFileName() : string;
}
