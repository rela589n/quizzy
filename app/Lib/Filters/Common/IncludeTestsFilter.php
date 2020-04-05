<?php


namespace App\Lib\Filters\Common;


use App\Lib\Filters\Filter;

class IncludeTestsFilter extends Filter
{
    protected function filters()
    {
        return ['notEmptyCount', 'isNecessary'];
    }

    /**
     * @param array $arr
     * @return bool
     */
    public function notEmptyCount($arr)
    {
        return !empty($arr['count']);
    }

    /**
     * @param array $arr
     * @return bool
     */
    public function isNecessary($arr)
    {
        return isset($arr['necessary']);
    }
}
