<?php

declare(strict_types=1);

namespace App\Lib\Filters\Eloquent\ResultFilters;

use App\Models\TestResults\TestResultQueryBuilder;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class TestNameFilter implements QueryFilter
{
    private string $testName;

    public function __construct(string $testName) { $this->testName = $testName; }

    public function apply(TestResultQueryBuilder $builder): void
    {
        $builder->whereHas(
            'test',
            fn($q) => $q->where('name', 'like', "%$this->testName%"),
        );
    }
}
