<?php

declare(strict_types=1);


namespace App\Models\Departments;

use App\Models\Administrator;
use App\Models\Administrators\AdministratorsEloquentBuilder;
use App\Models\Department;
use App\Models\Query\CustomEloquentBuilder;

/** @mixin Department */
final class DepartmentEloquentBuilder extends CustomEloquentBuilder
{
    public function availableForAdmin(Administrator $administrator)
    {
        if ($administrator->can('viewAll', Department::class)) {
            return $this;
        }

        return $this->whereHas(
            'administrators',
            fn(AdministratorsEloquentBuilder $query) => $query->where('id', $administrator->id)
        );
    }
}
