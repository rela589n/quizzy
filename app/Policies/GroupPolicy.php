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

    /**
     * Determine whether the user can view the student group.
     *
     * @param  Administrator  $user
     * @param  StudentGroup  $group
     * @return bool
     */
    public function view(Administrator $user, StudentGroup $group): bool
    {
        return $group->isOwnedBy($user) || $user->can('view-groups');
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
        return $user->can('update-groups');
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
        return $user->can('delete-groups');
    }
}
