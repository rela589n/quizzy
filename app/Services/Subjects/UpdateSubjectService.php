<?php


namespace App\Services\Subjects;


use App\Models\TestSubject;

class UpdateSubjectService extends StoreSubjectService
{
    /**
     * @param  TestSubject  $subject
     * @return $this
     */
    public function setSubject(TestSubject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    protected function doHandle(): TestSubject
    {
        $this->subject->update($this->fields);

        return $this->subject;
    }
}
