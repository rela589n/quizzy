<?php


namespace App\Services\Tests;


use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class MarkPercentsManager
{
    /**
     * @var EloquentCollection|callable
     */
    protected $models;

    protected function resolveModels()
    {
        if (is_callable($this->models)) {
            $this->models = ($this->models)();
        }

        return $this->models;
    }

    /**
     * @param  EloquentCollection|callable  $models
     * @return $this
     */
    public function setModels($models): self
    {
        $this->models = $models;

        return $this;
    }

    public function handle(?array $old)
    {
        if ($old === null) {
            return $this->resolveModels();
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
