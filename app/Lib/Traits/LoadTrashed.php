<?php


namespace App\Lib\Traits;


trait LoadTrashed
{
    public function loadTrashed($relations, bool $loadMissing = true)
    {
        if (is_string($relations)) {
            $relations = [$relations];
        }

        $loadArray = [];
        foreach ($relations as $relation) {
            $loadArray[$relation] = function ($query) {
                $query->withTrashed();
            };
        }

        $method = sprintf('load%s', $loadMissing ? 'Missing' : '');
        $this->$method($loadArray);
        return $this;
    }
}
