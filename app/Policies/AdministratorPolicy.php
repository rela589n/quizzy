<?php

namespace App\Policies;

use App\Models\Administrator;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdministratorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the administrator.
     *
     * @param  Administrator  $user
     * @param  Administrator  $model
     * @return bool
     */
    public function view(Administrator $user, Administrator $model): bool
    {
        return $user->can('view-administrators')
            && $this->isNotSystem($model);
    }

    /**
     * Determine whether the user can update the administrator.
     *
     * @param  Administrator  $user
     * @param  Administrator  $model
     * @return bool
     */
    public function update(Administrator $user, Administrator $model): bool
    {
        return $user->can('update-administrators')
            && $this->isNotSystem($model);
    }

    /**
     * Determine whether the user can delete the administrator.
     *
     * @param  Administrator  $user
     * @param  Administrator  $model
     * @return bool
     */
    public function delete(Administrator $user, Administrator $model): bool
    {
        return $user->can('delete-administrators')
            && $this->isNotSystem($model);
    }

    public function isNotSystem(Administrator $administrator): bool
    {
        return $administrator->surname !== 'system';
    }
}
