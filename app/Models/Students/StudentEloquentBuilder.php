<?php

declare(strict_types=1);


namespace App\Models\Students;

use App\Models\Administrator;
use App\Models\Query\CustomEloquentBuilder;
use App\Models\StudentGroups\StudentGroupEloquentBuilder;
use App\Models\User;

/** @mixin User */
final class StudentEloquentBuilder extends CustomEloquentBuilder
{
    public function availableForAdmin(Administrator $administrator)
    {
        if ($administrator->can('viewAll', User::class)) {
            return $this;
        }

        return $this->whereHas(
            'studentGroup',
            fn(StudentGroupEloquentBuilder $query) => $query->availableForAdmin($administrator)
        );
    }
}
