<?php


namespace App\Lib\Filters;


use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;

abstract class ResultFilter
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function applyFilters(array $filters, &$filterParam): bool
    {
        foreach ($filters as $filter => $value) {
            if (method_exists($this, $filter) &&
                $this->$filter($filterParam, $value) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function applyQueryFilters($query)
    {
        $this->applyFilters($this->queryFilters(), $query);
        return $query;
    }

    public function apply(EloquentCollection $results)
    {
        $this->loadRelations($results);
        $filters = $this->filters();

        return $results->filter(function ($testResult) use(&$filters) {
            return $this->applyFilters($filters, $testResult);
        });
    }

    protected function loadRelations(EloquentCollection $results)
    {
        //
    }

    protected function filters()
    {
        return [];
    }

    protected function queryFilters()
    {
        return [];
    }
}
