<?php


namespace App\Lib\Filters;


use App\Models\Administrator;
use App\Models\StudentGroup;

class AvailableGroupsFilter extends ResultFilter
{
    /**
     * @var Administrator
     */
    private $user;

    /**
     * AvailableGroupsFilter constructor.
     * @param Administrator $user
     */
    public function __construct(Administrator $user)
    {
        $this->user = $user;
    }

    /**
     * @param Administrator $user
     */
    public function setUser(Administrator $user): void
    {
        $this->user = $user;
    }

    protected function filters()
    {
        if ($this->user->can('view-groups')) {
            return [];
        }

        return ['maintainedBy' => $this->user];
    }

    /**
     * @param StudentGroup $studentGroup
     * @param Administrator $user
     * @return bool
     */
    protected function maintainedBy($studentGroup, $user)
    {
        return $user->can('view', $studentGroup);
    }
}
