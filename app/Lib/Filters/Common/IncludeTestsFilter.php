<?php


namespace App\Lib\Filters\Common;


use App\Lib\Filters\Filter;

class IncludeTestsFilter extends Filter
{
    protected function filters(): array
    {
        return ['notEmptyCount', 'isNecessary'];
    }

    public function notEmptyCount($arr): bool
    {
        return !empty($arr['count']);
    }

    public function isNecessary($arr): bool
    {
        return isset($arr['necessary']);
    }
}
