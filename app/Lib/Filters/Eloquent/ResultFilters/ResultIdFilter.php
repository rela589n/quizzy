<?php

declare(strict_types=1);

namespace App\Lib\Filters\Eloquent\ResultFilters;

use App\Models\TestResults\TestResultQueryBuilder;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class ResultIdFilter implements QueryFilter
{
    private int $resultId;

    public function __construct(int $resultId) { $this->resultId = $resultId; }

    public function apply(TestResultQueryBuilder $builder): void
    {
        $builder->where('id', $this->resultId);
    }
}
