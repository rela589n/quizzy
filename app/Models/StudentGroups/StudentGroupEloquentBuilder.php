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
        if ($administrator->can('viewAll', StudentGroup::class)) {
            return $this;
        }

        if ($administrator->hasRole('class-monitor')) {
            return $this->where('created_by', $administrator->id);
        }

        return $this->whereHas(
            'department',
            fn(DepartmentEloquentBuilder $query) => $query->availableForAdmin($administrator)
        );
    }
}
