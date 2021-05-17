<?php

namespace App\Nova\Filters;

use App\Factories\MarkEvaluatorsFactory;
use App\Lib\Filters\Eloquent\ResultFilters\ResultMarkRangeFilter;
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

    public $name = 'Оцінки';

    public function __construct(int $testId)
    {
        $this->markEvaluator = app(MarkEvaluatorsFactory::class)
            ->resolve(Test::findOrFail($testId));

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

        return $query->applyQueryFilter(
            new ResultMarkRangeFilter(
                $this->markEvaluator,
                $fromMark,
                $toMark,
            ),
        );
    }
}
