<?php

namespace App\Policies;

use App\Models\Administrator;
use App\Models\StudentGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    public function viewAny(Administrator $user): bool
    {
        return $user->can('view-groups');
    }

    public function viewAll(Administrator $user): bool
    {
        return $user->can('view-all-groups');
    }

    public function create(Administrator $user): bool
    {
        return $user->can('create-groups');
    }

    /**
     * Determine whether the user can view the student group.
     *
     * @param  Administrator  $user
     * @param  StudentGroup  $group
     * @return bool
     */
    public function view(Administrator $user, StudentGroup $group): bool
    {
        return $this->viewAll($user)
            || $group->isAvailableForAdmin($user);
    }

    /**
     * Determine whether the user can update the student group.
     *
     * @param  Administrator  $user
     * @param  StudentGroup  $group
     * @return bool
     */
    public function update(Administrator $user, StudentGroup $group): bool
    {
        return $user->can('update-all-groups')
            || ($user->can('update-groups')
                && $group->isAvailableForAdmin($user));
    }

    /**
     * Determine whether the user can delete the student group.
     *
     * @param  Administrator  $user
     * @param  StudentGroup  $group
     * @return bool
     */
    public function delete(Administrator $user, StudentGroup $group): bool
    {
        return $user->can('delete-all-groups')
            || ($user->can('delete-groups')
                && $group->isAvailableForAdmin($user));
    }
}
