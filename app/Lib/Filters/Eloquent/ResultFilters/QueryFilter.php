<?php

declare(strict_types=1);

namespace App\Lib\Filters\Eloquent\ResultFilters;

use App\Models\TestResults\TestResultQueryBuilder;

interface QueryFilter
{
    public function apply(TestResultQueryBuilder $builder): void;
}
