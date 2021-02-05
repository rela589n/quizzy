<?php

declare(strict_types=1);


namespace App\Models\StudentGroups;

use App\Models\Administrator;
use App\Models\Departments\DepartmentEloquentBuilder;
use App\Models\Query\CustomEloquentBuilder;
use App\Models\StudentGroup;

/** @mixin StudentGroup */
final class StudentGroupEloquentBuilder extends CustomEloquentBuilder
{
    public function availableForAdmin(Administrator $administrator)
    {
        if ($administrator->can('viewAny', StudentGroup::class)) {
            return $this;
        }

        return $this->whereHas(
            'department',
            fn(DepartmentEloquentBuilder $query) => $query->availableForAdmin($administrator)
        );
    }
}
