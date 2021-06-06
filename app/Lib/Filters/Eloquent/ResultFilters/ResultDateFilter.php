<?php

declare(strict_types=1);

namespace App\Lib\Filters\Eloquent\ResultFilters;

use App\Models\TestResults\TestResultQueryBuilder;
use Carbon\Carbon;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class ResultDateFilter implements QueryFilter
{
    private Carbon $date;

    public function __construct(Carbon $date) { $this->date = $date; }

    public function apply(TestResultQueryBuilder $builder): void
    {
        $builder->whereDate('created_at', $this->date);
    }
}
