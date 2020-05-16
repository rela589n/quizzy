<?php


namespace App\Services\Subjects;


use App\Models\TestSubject;

class CreateSubjectService extends StoreSubjectService
{
    protected function doHandle(): TestSubject
    {
        return TestSubject::create($this->fields);
    }
}
