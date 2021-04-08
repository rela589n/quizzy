<?php

namespace App\Nova\Metrics;

use App\Models\TestResult;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

class LastMark extends Value
{
    public $name = 'Остання оцінка';

    public $onlyOnDetail = true;

    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request, TestResult $result)
    {
        $result = TestResult::query()
            ->ofTest($result->test_id)
            ->ofUser($result->user_id)
            ->withResultPercents()
            ->latest()
            ->firstOrFail();

        return new ValueResult($result->result_mark);
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
