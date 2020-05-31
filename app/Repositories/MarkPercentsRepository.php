<?php


namespace App\Repositories;


use App\Models\Test;

class MarkPercentsRepository
{
    public function mapForTest(Test $test)
    {
        return $test->marksPercents;
    }
}
