<?php


namespace App\Lib\Traits;


use App\Lib\Filters\ResultFilter;
use Illuminate\Database\Eloquent\Builder;

trait FilteredScope
{
    /**
     * @param Builder $query
     * @param ResultFilter $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFiltered($query, ResultFilter $filters)
    {
        $response = $filters->applyQueryFilters($query)->get();

        return $filters->apply($response);
    }
}
