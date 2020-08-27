<?php


namespace App\Repositories\Queries;


use App\Models\BaseUser;
use App\Models\Department;
use App\Models\StudentGroup;
use Illuminate\Database\Eloquent\Builder;

class AccessibleDepartments
{
    protected BaseUser $user;

    public function setUser(BaseUser $user): void
    {
        $this->user = $user;
    }

    /**
     * @param  Builder  $departmentsQuery
     */
    public function apply($departmentsQuery): void
    {
        $departmentsQuery->whereHas(
            'studentGroups',
            function ($q) {
                $this->groupsQuerySelector($q);
            }
        );
    }

    public function isAccessible(Department $department): bool
    {
        if ($department->relationLoaded('studentGroups')) {
            return $this->groupsLoadedSelector($department)
                ->isNotEmpty();
        }

        return $department->studentGroups()->where(
            function ($q) {
                $this->groupsQuerySelector($q);
            }
        )->exists();
    }

    protected function groupsLoadedSelector(Department $department)
    {
        return $department->studentGroups
            ->where('created_by', $this->user->id);
    }

    /**
     * @param  StudentGroup|Builder  $groupQuery
     */
    protected function groupsQuerySelector($groupQuery): void
    {
        $groupQuery->whereCreatedBy($this->user->id);
    }
}
