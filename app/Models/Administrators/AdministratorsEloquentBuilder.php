<?php

declare(strict_types=1);


namespace App\Models\Administrators;

use App\Models\Administrator;
use App\Models\Query\CustomEloquentBuilder;

/** @mixin Administrator */
final class AdministratorsEloquentBuilder extends CustomEloquentBuilder
{
    public function availableToViewBy(Administrator $user): self
    {
        if ($user->hasRole('super-admin')) {
            return $this;
        }

        if ($user->hasRole('teacher')) {
            return $this->role(Administrator::ROLES_FOR_TEACHER);
        }

        return $this->whereRaw('1=0');
    }
}
