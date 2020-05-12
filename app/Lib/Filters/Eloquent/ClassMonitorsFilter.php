<?php


namespace App\Lib\Filters\Eloquent;


use App\Models\Administrator;
use App\Models\StudentGroup;

class ClassMonitorsFilter extends ResultFilter
{
    /**
     * @var StudentGroup
     */
    protected $group;

    public function setGroup(StudentGroup $group): void
    {
        $this->group = $group;
    }

    protected function queryFilters()
    {
        return ['availableClassMonitors'];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|Administrator $query
     */
    protected function availableClassMonitors($query)
    {
        $query->doesntHave('studentGroup')
            ->union($this->group->classMonitor()->toBase());
    }
}
