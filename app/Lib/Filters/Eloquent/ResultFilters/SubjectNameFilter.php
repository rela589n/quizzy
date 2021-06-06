<?php

declare(strict_types=1);

namespace App\Lib\Filters\Eloquent\ResultFilters;

use App\Models\TestResults\TestResultQueryBuilder;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class SubjectNameFilter implements QueryFilter
{
    private string $subjectName;

    public function __construct(string $subjectName)
    {
        $this->subjectName = $subjectName;
    }

    public function apply(TestResultQueryBuilder $builder): void
    {
        $builder->whereHas(
            'test.subject',
            fn($q) => $q->where('name', 'like', "%$this->subjectName%")
        );
    }
}
