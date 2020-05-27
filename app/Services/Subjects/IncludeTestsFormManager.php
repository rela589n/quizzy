<?php


namespace App\Services\Subjects;


use App\Models\Test;
use App\Models\TestSubject;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class IncludeTestsFormManager
{
    /**
     * @var Test
     */
    protected $test;

    /**
     * @param Test $test
     * @return IncludeTestsFormManager
     */
    public function setTest(Test $test): self
    {
        $this->test = $test;
        $this->buildPivotsMap();

        return $this;
    }

    /**
     * @var TestSubject
     */
    protected $subject;

    /**
     * @param TestSubject $subject
     * @return IncludeTestsFormManager
     */
    public function setSubject(TestSubject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @var array
     */
    protected $pivotsMap;

    protected function buildPivotsMap()
    {
        $this->pivotsMap = [];

        foreach ($this->test->tests as $includeTest) {
            $this->pivotsMap[$includeTest->id] = $includeTest->pivot;
        }
    }

    /**
     * @param EloquentCollection|TestSubject[] $toInclude
     */
    public function transform(EloquentCollection $toInclude): void
    {
        foreach ($toInclude as $includeSubject) {

            foreach ($includeSubject->tests as $includeTest) {

                $pivot = $this->pivotsMap[$includeTest->id] ?? null;

                $includeTest->isNecessary = (bool)old("include.{$includeTest->id}.necessary", isset($pivot));
                $includeTest->includeCount = old("include.{$includeTest->id}.count", $pivot->questions_quantity ?? '');

                $includeSubject->isExpanded |= $includeTest->isNecessary;
            }

            $includeSubject->isExpanded |= (isset($this->test) && $includeSubject->id === $this->test->test_subject_id) ||
                (isset($this->subject) && $includeSubject->id === $this->subject->id);
        }
    }
}
