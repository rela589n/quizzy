<?php


namespace App\Lib\Filters\Eloquent;


use App\Models\Administrator;
use App\Repositories\Queries\AccessibleDepartments as AccessibleDepartmentQueries;

class AvailableDepartmentsFilter extends ResultFilter
{
    private $user;
    private $accessibleManager;

    /**
     * AvailableGroupsFilter constructor.
     * @param Administrator $user
     * @param AccessibleDepartmentQueries $departmentQueries
     */
    public function __construct(Administrator $user, AccessibleDepartmentQueries $departmentQueries)
    {
        $this->user = $user;
        $this->accessibleManager = $departmentQueries;

        $this->accessibleManager->setUser($this->user);
    }

    protected function queryFilters()
    {
        if ($this->user->can('view-departments')) {
            return [];
        }

        return ['hasGroupAccessibleToUser'];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    protected function hasGroupAccessibleToUser($query)
    {
        $this->accessibleManager->apply($query);
    }
}
