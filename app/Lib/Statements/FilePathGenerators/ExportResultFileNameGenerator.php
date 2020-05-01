<?php


namespace App\Lib\Statements\FilePathGenerators;


use App\Models\Test;

class ExportResultFileNameGenerator extends ResultFileNameGenerator
{
    protected $storageDir = 'app/public/exports/';
    protected $filePrefix = 'Експорт';

    /**
     * @var Test
     */
    protected $test;

    /**
     * @param Test $test
     */
    public function setTest(Test $test): void
    {
        $this->test = $test;
    }

    protected function generateFileName(): string
    {
        return sprintf(
            '%s (%s - %s).docx',
            $this->filePrefix,
            $this->test->subject->name,
            $this->test->name,
        );
    }
}
