<?php


namespace App\Lib\Filters\Eloquent;


use App\Models\Administrator;
use App\Repositories\Queries\AccessibleDepartments as AccessibleDepartmentQueries;
use Illuminate\Database\Eloquent\Builder;

class AvailableDepartmentsFilter extends ResultFilter
{
    private Administrator $user;
    private AccessibleDepartmentQueries $accessibleManager;

    public function __construct(Administrator $user, AccessibleDepartmentQueries $departmentQueries)
    {
        $this->user = $user;
        $this->accessibleManager = $departmentQueries;

        $this->accessibleManager->setUser($this->user);
    }

    protected function queryFilters(): array
    {
        if ($this->user->can('view-departments')) {
            return [];
        }

        return ['hasGroupAccessibleToUser'];
    }

    /**
     * @param  Builder  $query
     */
    protected function hasGroupAccessibleToUser($query): void
    {
        $this->accessibleManager->apply($query);
    }
}
