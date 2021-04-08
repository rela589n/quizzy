<?php


namespace App\Services\Tests\Grading;


use App\Models\MarkPercent;
use App\Models\Test;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

final class GradingTableService
{
    /**
     * @param  Test  $test
     * @param  Collection|MarkPercent[]  $marksPercents
     */
    public function attachForTest(Test $test, Collection $marksPercents): void
    {
        $this->createListenerForSave(
            $test,
            function () use ($marksPercents, $test) {
                $this->detachMarkPercents($test);

                $marksPercents = $this->prepareMarkPercents($marksPercents);

                $this->saveMarkPercents($test, $marksPercents);
            }
        );
    }

    protected function detachMarkPercents(Test $test): void
    {
        $test->marksPercents()->delete();
    }

    /**
     * @param  Collection|MarkPercent[]  $collection
     * @return Collection|MarkPercent[]
     */
    protected function prepareMarkPercents(Collection $collection): Collection
    {
        return $collection->sortBy(
            static function (MarkPercent $element) {
                return $element->mark;
            }
        );
    }

    protected function saveMarkPercents(Test $test, Collection $collection): void
    {
        $test->marksPercents()->saveMany($collection);
        $test->setRelation('marksPercents', $collection);
    }

    private function createListenerForSave(Test $test, \Closure $listener)
    {
        Test::saved(
            function (Test $savedTest) use ($listener, $test) {
                if ($savedTest !== $test) {
                    return;
                }

                $listener();
            }
        );
    }
}
