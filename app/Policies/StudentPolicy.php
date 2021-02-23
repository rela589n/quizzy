<?php

namespace App\Policies;

use App\Models\Administrator;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;

    public function create(Administrator $administrator): bool
    {
        return $administrator->can('create-students');
    }

    public function viewAny(Administrator $administrator): bool
    {
        return $administrator->can('view-students');
    }

    public function viewAll(Administrator $administrator): bool
    {
        return $administrator->can('view-all-students');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  Administrator  $user
     * @param  User  $model
     * @return bool
     */
    public function view(Administrator $user, User $model): bool
    {
        return $this->viewAll($user)
            || ($user->can('view-students')
                && $model->isAvailableForAdmin($user));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  Administrator  $user
     * @param  User  $model
     * @return bool
     */
    public function update(Administrator $user, User $model): bool
    {
        return $user->can('update-all-students')
            || ($user->can('update-students')
                && $model->isAvailableForAdmin($user));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  Administrator  $user
     * @param  User  $model
     * @return bool
     */
    public function delete(Administrator $user, User $model): bool
    {
        return $user->can('delete-all-students')
            || ($user->can('delete-students')
                && $model->isAvailableForAdmin($user));
    }

    public function promoteToClassMonitor(Administrator $user, User $model): bool
    {
        return $user->can('make-student-class-monitor')
            && $user->can('update', $model);
    }
}
