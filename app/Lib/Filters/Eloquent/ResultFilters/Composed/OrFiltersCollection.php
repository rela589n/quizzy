<?php

declare(strict_types=1);

namespace App\Lib\Filters\Eloquent\ResultFilters\Composed;

use App\Lib\Filters\Eloquent\ResultFilters\QueryFilter;
use App\Models\TestResults\TestResultQueryBuilder;
use JetBrains\PhpStorm\Immutable;

use function array_map;

#[Immutable]
final class OrFiltersCollection implements QueryFilter
{
    private array $filters;

    public function __construct(array $filters)
    {
        $this->filters = array_map(static fn(QueryFilter $f) => $f, $filters);
    }

    public function apply(TestResultQueryBuilder $builder): void
    {
        $builder->where(
            function (TestResultQueryBuilder $query) {
                foreach ($this->filters as $filter) {
                    $query->orWhere(
                        fn(TestResultQueryBuilder $q) => $filter->apply($q)
                    );
                }
            },
        );
    }
}
