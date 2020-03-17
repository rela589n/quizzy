<?php


namespace App\Lib\Statements\FilePathGenerators;


use App\Models\StudentGroup;
use App\Models\Test;

class GroupResultFileNameGenerator extends ResultFileNameGenerator
{
    /**
     * @var StudentGroup
     */
    protected $group;

    /**
     * @var Test
     */
    protected $test;

    /**
     * @param StudentGroup $group
     */
    public function setGroup(StudentGroup $group): void
    {
        $this->group = $group;
    }

    public function setTest(Test $test)
    {
        $this->test = $test;
    }

    protected function generateFileName(): string
    {
        return sprintf('%s (%s %s) - %s.docx',
            $this->filePrefix,
            $this->test->subject->name,
            $this->test->name,
            $this->group->name
        );
    }
}
