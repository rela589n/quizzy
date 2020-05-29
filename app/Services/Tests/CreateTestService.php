<?php


namespace App\Services\Tests;


use App\Models\Test;
use Illuminate\Support\Collection;

class CreateTestService extends StoreTestService
{
    protected function doHandle(): Test
    {
        return Test::create($this->fields);
    }

    protected function applyIncludeTransforming(Collection $include): Collection
    {
        $include = parent::applyIncludeTransforming($include);

        $include[$this->test->id] = [
            'questions_quantity' => static::NEW_TEST_INCLUDE_QUANTITY
        ];

        return $include;
    }

    protected function handleCustomEvaluation(Collection $collection)
    {
        $this->saveMarkPercents($collection);
    }
}
