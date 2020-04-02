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
     * @param Administrator $user
     * @param Administrator $model
     * @return mixed
     */
    public function view(Administrator $user, Administrator $model)
    {
        return $user->can('view-administrators');
    }

    /**
     * Determine whether the user can update the administrator.
     *
     * @param Administrator $user
     * @param Administrator $model
     * @return mixed
     */
    public function update(Administrator $user, Administrator $model)
    {
        return $user->can('update-administrators');
    }

    /**
     * Determine whether the user can delete the administrator.
     *
     * @param Administrator $user
     * @param Administrator $model
     * @return mixed
     */
    public function delete(Administrator $user, Administrator $model)
    {
        return $user->can('delete-administrators');
    }

}
