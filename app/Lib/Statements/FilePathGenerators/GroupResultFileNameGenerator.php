<?php


namespace App\Lib\Statements\FilePathGenerators;


use App\Models\StudentGroup;
use App\Models\Test;

class GroupResultFileNameGenerator extends ResultFileNameGenerator
{
    protected StudentGroup $group;
    protected Test $test;

    public function setGroup(StudentGroup $group): void
    {
        $this->group = $group;
    }

    public function setTest(Test $test): void
    {
        $this->test = $test;
    }

    public function generateFileName(): string
    {
        return sprintf(
            '%s (%s %s) - %s.docx',
            $this->filePrefix,
            $this->test->subject->name,
            $this->test->name,
            $this->group->name
        );
    }
}
