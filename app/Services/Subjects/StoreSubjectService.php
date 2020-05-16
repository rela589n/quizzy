<?php


namespace App\Services\Subjects;


use App\Models\TestSubject;
use Illuminate\Foundation\Http\FormRequest;

abstract class StoreSubjectService
{
    /** @var array */
    protected $fields = [];

    /** @var TestSubject */
    protected $subject;

    public function handle(FormRequest $request): TestSubject
    {
        $this->fields = $request->validated();
        $this->subject = $this->doHandle();

        $this->syncCourses($this->fields['courses']);
        $this->syncDepartments($this->fields['departments']);

        return $this->subject;
    }

    protected abstract function doHandle(): TestSubject;

    protected function syncCourses(array $courses): void
    {
        $this->subject->courses()->sync($courses);
    }

    protected function syncDepartments(array $departments): void
    {
        $this->subject->departments()->sync($departments);
    }
}
