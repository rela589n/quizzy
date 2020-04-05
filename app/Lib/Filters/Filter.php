<?php


namespace App\Lib\Filters;


use Illuminate\Support\Collection;

abstract class Filter
{
    protected function applyFilters(array $filters, &$filterParam): bool
    {
        foreach ($filters as $filter => $value) {
            if (method_exists($this, $filter)) {
                $methodName = $filter;
                $methodParam = $value;
            }
            elseif (method_exists($this, $value)) {
                $methodName = $value;
                $methodParam = $filter;
            }

            if (isset($methodName) && $this->$methodName($filterParam, $methodParam ?? null) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Collection $data
     * @return Collection
     */
    public function apply($data)
    {
        $filters = $this->filters();

        return $data->filter(function ($element) use(&$filters) {
            return $this->applyFilters($filters, $element);
        });
    }

    protected function filters()
    {
        return [];
    }
}
