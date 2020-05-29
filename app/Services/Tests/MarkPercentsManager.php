<?php


namespace App\Services\Tests;


use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class MarkPercentsManager
{
    /**
     * @var EloquentCollection
     */
    protected $models;

    protected function models()
    {
        if (is_callable($this->models)) {
            $this->models = ($this->models)();
        }

        return $this->models;
    }

    /**
     * @param EloquentCollection|callable $models
     * @return $this
     */
    public function setModels($models)
    {
        $this->models = $models;

        return $this;
    }

    public function handle(?array $old)
    {
        if ($old === null) {
            return $this->models();
        }

        $response = [];
        foreach ($old as $id => $info) {
            $markPercent = (object)$info;
            $markPercent->id = $id;

            $response[] = $markPercent;
        }

        return $response;
    }
}
