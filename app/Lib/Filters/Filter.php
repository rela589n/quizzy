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
            } elseif (method_exists($this, $value)) {
                $methodName = $value;
                $methodParam = $filter;
            }

            if (isset($methodName) && $this->$methodName($filterParam, $methodParam ?? null) === false) {
                return false;
            }
        }

        return true;
    }

    public function apply(Collection $data): Collection
    {
        $filters = $this->filters();

        return $data->filter(
            function ($element) use (&$filters) {
                return $this->applyFilters($filters, $element);
            }
        );
    }

    protected function filters(): array
    {
        return [];
    }
}
