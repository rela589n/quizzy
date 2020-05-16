<?php


namespace App\Services\Tests;


use App\Models\Test;
use Illuminate\Support\Collection;

class UpdateTestService extends StoreTestService
{
    public function setTest(Test $test)
    {
        $this->test = $test;

        return $this;
    }

    protected function doHandle(): Test
    {
        $this->test->update($this->fields);

        return $this->test;
    }

    protected function applyIncludeTransforming(Collection $include): Collection
    {
        $include = parent::applyIncludeTransforming($include);

        if (!isset($this->fields['include'][$this->test->id])) {

            $include[$this->test->id] = [
                'questions_quantity' => static::NEW_TEST_INCLUDE_QUANTITY
            ];
        }

        return $include;
    }
}
