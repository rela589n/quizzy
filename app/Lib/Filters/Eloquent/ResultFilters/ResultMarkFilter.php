<?php

declare(strict_types=1);

namespace App\Lib\Filters\Eloquent\ResultFilters;

use App\Lib\TestResults\MarkEvaluator;
use App\Models\TestResults\TestResultQueryBuilder;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class ResultMarkFilter implements QueryFilter
{
    private ResultMarkRangeFilter $filter;

    public function __construct(MarkEvaluator $markEvaluator, int $mark)
    {
        $this->filter = new ResultMarkRangeFilter($markEvaluator, $mark, $mark);
    }

    public function apply(TestResultQueryBuilder $builder): void
    {
        $this->filter->apply($builder);
    }
}
