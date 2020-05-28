<?php


namespace App\Lib\TestResults;


use App\Models\MarkPercent;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class MarkPercentsMapCreator
{
    /**
     * @var EloquentCollection|MarkPercent[]
     */
    protected $models;

    public function setModels(EloquentCollection $models)
    {
        $this->models = $models;

        return $this;
    }

    public function getMap()
    {
        return $this->models->sortByDesc('mark')->mapWithKeys(function(MarkPercent $model) {
            return [$model->mark => $model->percent];
        })->toArray();
    }
}
