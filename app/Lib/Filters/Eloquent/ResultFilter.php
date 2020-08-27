<?php


namespace App\Lib\Filters\Eloquent;


use App\Lib\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

abstract class ResultFilter extends Filter
{
    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function applyQueryFilters($query)
    {
        $this->applyFilters($this->queryFilters(), $query);
        return $query;
    }

    /**
     * @param  Collection  $results
     * @return Collection
     */
    public function apply($results): Collection
    {
        $this->loadRelations($results);
        return parent::apply($results);
    }

    protected function loadRelations(Collection $results): void
    {
        //
    }

    protected function queryFilters(): array
    {
        return [];
    }
}
