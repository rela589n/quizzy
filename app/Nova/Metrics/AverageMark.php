<?php

namespace App\Nova\Metrics;

use App\Models\TestResult;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

class AverageMark extends Value
{
    public $name = 'Середня оцінка';

    public $onlyOnDetail = true;

    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request, TestResult $result)
    {
        $results = TestResult::query()
            ->ofTest($result->test_id)
            ->ofUser($result->user_id)
            ->withResultPercents()
            ->get();

        return new ValueResult($results->average(static fn(TestResult $r) => $r->result_mark));
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }
}
