<?php

namespace App\Nova\Filters;

use App\Factories\MarkEvaluatorsFactory;
use App\Lib\TestResults\MarkEvaluator;
use App\Models\Test;
use App\Models\TestResults\TestResultQueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Oleksiypetlyuk\NovaRangeFilter\NovaRangeFilter;

class TestResultMarksFilter extends NovaRangeFilter
{
    private MarkEvaluator $markEvaluator;

    public function __construct(int $testId)
    {
        $this->markEvaluator = app(MarkEvaluatorsFactory::class)
            ->setTest(Test::findOrFail($testId))
            ->resolve();

        $this->min = ($this->markEvaluator->minPossibleMark());

        $this->max = ($this->markEvaluator->maxPossibleMark());

        parent::__construct();
    }

    /**
     * @param  Request  $request
     * @param  TestResultQueryBuilder  $query
     * @param  mixed  $value
     *
     * @return EloquentBuilder
     */
    public function apply(Request $request, $query, $value)
    {
        $fromMark = Arr::first($value);
        $toMark = Arr::last($value);

        $shouldRestrictFromLeft = $this->min !== $fromMark;
        $shouldRestrictFromRight = $this->max !== $toMark;

        if (!$shouldRestrictFromLeft
            && !$shouldRestrictFromRight) {
            return $query;
        }

        if ($shouldRestrictFromLeft && $shouldRestrictFromRight) {
            return $query->whereMarkPercentBetween(
                $this->markEvaluator->leastPercentForMark($fromMark),
                $this->markEvaluator->leastPercentForMark(1 + $toMark) - MarkEvaluator::MARK_EPS,
            );
        }

        if ($shouldRestrictFromLeft) {
            return $query->whereMarkPercentAtLeast(
                $this->markEvaluator->leastPercentForMark($fromMark),
            );
        }

        if ($shouldRestrictFromRight) {
            return $query->whereMarkPercentAtMost(
                $this->markEvaluator->leastPercentForMark(1 + $toMark) - MarkEvaluator::MARK_EPS,
            );
        }

        throw new \LogicException('Should not get here');
    }
}
