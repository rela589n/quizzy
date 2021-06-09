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
        if (isset($this->group->department_id)) {
            $query->whereHas('departments', fn($q) => $q->where('id', $this->group->department_id));
        }

        $query->where(function ($subquery) {
            /** @var Builder $subquery */
            $subquery->whereDoesntHave('studentGroup');

            if (isset($this->group->id)) {
                $subquery->orWhereHas('studentGroup',  fn($q) => $q->where('id', $this->group->id));
            }
        });
    }
}
