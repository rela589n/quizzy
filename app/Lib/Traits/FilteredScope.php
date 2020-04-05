<?php


namespace App\Lib\Traits;


use App\Lib\Filters\Eloquent\ResultFilter;
use Illuminate\Database\Eloquent\Builder;

trait FilteredScope
{
    /**
     * @param Builder $query
     * @param \App\Lib\Filters\Eloquent\ResultFilter $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFiltered($query, ResultFilter $filters)
    {
        $response = $filters->applyQueryFilters($query)->get();

        return $filters->apply($response);
    }
}
