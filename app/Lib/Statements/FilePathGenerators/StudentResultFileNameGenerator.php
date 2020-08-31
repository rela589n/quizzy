<?php


namespace App\Lib\Statements\FilePathGenerators;


use App\Models\TestResult;

class StudentResultFileNameGenerator extends ResultFileNameGenerator
{
    protected TestResult $result;

    public function setResult(TestResult $result): void
    {
        $this->result = $result;
    }

    protected function generateFileName(): string
    {
        return sprintf(
            '%s (%s %s) - %s %s %s.docx',
            $this->filePrefix,
            $this->result->test->subject->name,
            $this->result->test->name,
            $this->result->user->surname,
            $this->result->user->name,
            $this->result->user->patronymic
        );
    }
}
