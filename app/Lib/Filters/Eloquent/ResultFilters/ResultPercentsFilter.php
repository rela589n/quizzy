<?php

declare(strict_types=1);

namespace App\Lib\Filters\Eloquent\ResultFilters;

use App\Models\TestResults\TestResultQueryBuilder;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class ResultPercentsFilter implements QueryFilter
{
    private float $eps = 5;
    private float $percents;

    public function __construct(float $percents)
    {
        $this->percents = $percents;
    }

    public function apply(TestResultQueryBuilder $builder): void
    {
        $builder->whereMarkPercentBetween(
            $this->percents - $this->eps,
            $this->percents + $this->eps,
        );
    }
}
