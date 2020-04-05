<?php


namespace App\Lib\Filters\Eloquent;


use App\Lib\Filters\Filter;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

abstract class ResultFilter extends Filter
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function applyQueryFilters($query)
    {
        $this->applyFilters($this->queryFilters(), $query);
        return $query;
    }

    /**
     * @param EloquentCollection $results
     * @return mixed
     */
    public function apply($results)
    {
        $this->loadRelations($results);
        return parent::apply($results);
    }

    protected function loadRelations(EloquentCollection $results)
    {
        //
    }

    protected function queryFilters()
    {
        return [];
    }
}
