<?php


namespace App\Lib\TestResults;


use App\Models\MarkPercent;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class MarkPercentsMapCreator
{
    protected EloquentCollection $models;

    public function setModels(EloquentCollection $models): MarkPercentsMapCreator
    {
        $this->models = $models;

        return $this;
    }

    public function getMap(): array
    {
        return $this->models->sortByDesc('mark')->mapWithKeys(
            static function (MarkPercent $model) {
                return [$model->mark => $model->percent];
            }
        )->toArray();
    }
}
