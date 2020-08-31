<?php


namespace App\Lib\Traits;


use App\Lib\Filters\Eloquent\ResultFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Trait FilteredScope
 * @package App\Lib\Traits
 * @method static Collection|static filtered(ResultFilter $filters)
 */
trait FilteredScope
{
    /**
     * @param  Builder  $query
     * @param  ResultFilter  $filters
     * @param  callable|null  $callback
     * @return Collection
     */
    public function scopeFiltered($query, ResultFilter $filters, callable $callback = null): Collection
    {
        $response = $filters->applyQueryFilters($query)->get();

        if (is_callable($callback)) {
            $callback($response);
        }

        return $filters->apply($response);
    }
}
