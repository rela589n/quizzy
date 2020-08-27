<?php


namespace App\Lib\Filters\Eloquent;


use App\Models\Administrator;

class AvailableGroupsFilter extends ResultFilter
{
    private Administrator $user;

    public function __construct(Administrator $user)
    {
        $this->user = $user;
    }

    public function setUser(Administrator $user): void
    {
        $this->user = $user;
    }

    protected function filters(): array
    {
        if ($this->user->can('view-groups')) {
            return [];
        }

        return ['maintainedBy' => $this->user];
    }

    protected function maintainedBy($studentGroup, $user): bool
    {
        return $user->can('view', $studentGroup);
    }
}
