<?php

namespace App\Policies;

use App\Models\Administrator;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param Administrator $user
     * @param User $model
     * @return mixed
     */
    public function view(Administrator $user, User $model)
    {
        return $model->isOwnedBy($user) || $user->can('view-students');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param Administrator $user
     * @param User $model
     * @return mixed
     */
    public function update(Administrator $user, User $model)
    {
        return $model->isOwnedBy($user) || $user->can('update-students');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param Administrator $user
     * @param User $model
     * @return mixed
     */
    public function delete(Administrator $user, User $model)
    {
        return $user->can('delete-students');
    }
}
