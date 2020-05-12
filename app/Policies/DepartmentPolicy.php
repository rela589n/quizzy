<?php

namespace App\Policies;

use App\Models\Administrator;
use App\Models\Department;
use App\Repositories\Queries\AccessibleDepartments as AccessibleDepartmentsQuery;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    protected $departmentQueries;

    public function __construct(AccessibleDepartmentsQuery $accessibleDepartments)
    {
        $this->departmentQueries = $accessibleDepartments;
    }

    /**
     * Determine whether the user can view the student group.
     *
     * @param Administrator $user
     * @param Department $department
     * @return mixed
     */
    public function view(Administrator $user, Department $department)
    {
        $this->departmentQueries->setUser($user);

        return $user->can('view-departments') ||
            $this->departmentQueries->isAccessible($department);
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
