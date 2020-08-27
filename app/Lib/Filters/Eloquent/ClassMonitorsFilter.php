<?php


namespace App\Lib\Filters\Eloquent;


use App\Models\Administrator;
use App\Models\StudentGroup;
use Illuminate\Database\Eloquent\Builder;

class ClassMonitorsFilter extends ResultFilter
{
    protected ?StudentGroup $group;

    public function setGroup(?StudentGroup $group): void
    {
        $this->group = $group;
    }

    protected function queryFilters(): array
    {
        return ['availableClassMonitors'];
    }

    /**
     * @param  Builder|Administrator  $query
     */
    protected function availableClassMonitors($query): void
    {
        $query->doesntHave('studentGroup');

        if (!is_null($this->group)) {
            $query->union($this->group->classMonitor()->toBase());
        }
    }
}
