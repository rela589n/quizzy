<?php


namespace App\Lib\Traits;


use App\Lib\Filters\Eloquent\ResultFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait FilteredScope
 * @package App\Lib\Traits
 * @method static \Illuminate\Database\Eloquent\Collection|static filtered(ResultFilter $filters)
 */
trait FilteredScope
{
    /**
     * @param Builder $query
     * @param ResultFilter $filters
     * @param callable|null $callback
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFiltered($query, ResultFilter $filters, callable $callback = null)
    {
        $response = $filters->applyQueryFilters($query)->get();

        ($callback ?? 'isset')($response);

        return $filters->apply($response);
    }
}
