<?php

namespace App\Policies;

use App\Models\Administrator;
use App\Models\Department;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the student group.
     *
     * @param Administrator $user
     * @param Department $department
     * @return mixed
     */
    public function view(Administrator $user, Department $department)
    {
        return $user->can('view-departments');
    }

    /**
     * Determine whether the user can update the student group.
     *
     * @param Administrator $user
     * @param Department $department
     * @return mixed
     */
    public function update(Administrator $user, Department $department)
    {
        return $user->can('update-departments');
    }

    /**
     * Determine whether the user can delete the student group.
     *
     * @param Administrator $user
     * @param Department $department
     * @return mixed
     */
    public function delete(Administrator $user, Department $department)
    {
        return $user->can('delete-departments');
    }
}
