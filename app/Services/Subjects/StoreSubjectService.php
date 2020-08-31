<?php


namespace App\Services\Subjects;


use App\Models\TestSubject;

abstract class StoreSubjectService
{
    protected array $fields = [];
    protected TestSubject $subject;

    public function handle(array $request): TestSubject
    {
        $this->fields = $request;
        $this->subject = $this->doHandle();

        $this->syncCourses($this->fields['courses']);
        $this->syncDepartments($this->fields['departments']);

        return $this->subject;
    }

    abstract protected function doHandle(): TestSubject;

    protected function syncCourses(array $courses): void
    {
        $this->subject->courses()->sync($courses);
    }

    protected function syncDepartments(array $departments): void
    {
        $this->subject->departments()->sync($departments);
    }
}
