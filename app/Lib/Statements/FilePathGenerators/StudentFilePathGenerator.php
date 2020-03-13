<?php


namespace App\Lib\Statements\FilePathGenerators;


class StudentFilePathGenerator extends FilePathGenerator
{
    protected function generateFileName(): string
    {
        return sprintf('%s (%s %s) - %s %s %s.docx',
            $this->filePrefix,
            $this->result->test->subject->name,
            $this->result->test->name,
            $this->result->user->surname,
            $this->result->user->name,
            $this->result->user->patronymic
        );
    }
}
