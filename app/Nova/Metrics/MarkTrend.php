<?php

namespace App\Nova\Metrics;

use App\Models\TestResult;
use DateInterval;
use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Metrics\TrendResult;

class MarkTrend extends Trend
{
    public $name = 'Тенденція оцінок';

    public $onlyOnDetail = true;

    /**
     * Calculate the value of the metric.
     *
     * @param  NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request, TestResult $result)
    {
        $results = TestResult::query()
            ->ofTest($result->test_id)
            ->ofUser($result->user_id)
            ->orderBy('created_at')
            ->withResultPercents()
            ->get();

        /** @var TestResult $result */
        $result = $results->find($result->id);

        $results = $results->keyBy('id');
        $currentKey = 0;
        foreach ($results as $id => $_result) {
            if ($id === $result->id) {
                break;
            }

            ++$currentKey;
        }

        return (new TrendResult())
            ->trend(
                $results->pluck('result_mark')
                    ->values()
                    ->keyBy(
                        static fn($value, $key) => sprintf(
                            'спроба %d%s',
                            $key + 1,
                            ($key !== $currentKey) ? '' : ' (поточна)'
                        )
                    )->toArray()
            )
            ->withoutSuffixInflection();
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  DateTimeInterface|DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }
}
