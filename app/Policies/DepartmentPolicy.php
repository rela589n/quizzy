<?php

namespace App\Policies;

use App\Models\Administrator;
use App\Models\Department;
use App\Repositories\Queries\AccessibleDepartments as AccessibleDepartmentsQuery;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    protected AccessibleDepartmentsQuery $departmentQueries;

    public function __construct(AccessibleDepartmentsQuery $accessibleDepartments)
    {
        $this->departmentQueries = $accessibleDepartments;
    }

    public function viewAny(Administrator $user): bool
    {
        return $user->can('view-departments');
    }

    /**
     * Determine whether the user can view the student group.
     *
     * @param  Administrator  $user
     * @param  Department  $department
     * @return bool
     */
    public function view(Administrator $user, Department $department): bool
    {
        $this->departmentQueries->setUser($user);

        return $user->can('view-departments') ||
            $this->departmentQueries->isAccessible($department);
    }

    /**
     * Determine whether the user can update the student group.
     *
     * @param  Administrator  $user
     * @param  Department  $department
     * @return bool
     */
    public function update(Administrator $user, Department $department): bool
    {
        return $user->can('update-departments');
    }

    /**
     * Determine whether the user can delete the student group.
     *
     * @param  Administrator  $user
     * @param  Department  $department
     * @return bool
     */
    public function delete(Administrator $user, Department $department): bool
    {
        return $user->can('delete-departments');
    }
}
