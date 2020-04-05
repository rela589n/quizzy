<?php


namespace App\Lib\Transformers;


use Illuminate\Database\Eloquent\Model;

abstract class RequestDtoModelTransformer
{
    protected function withProperties(object $obj, array $set): object
    {
        foreach ($set as $setKey => $setValue) {
            $obj->$setKey = $setValue;
        }

        return $obj;
    }

    public function modelToDto(Model $model, array $setProperties = [])
    {
        return $this->withProperties((object)$model->toArray(), $setProperties);
    }

    public function requestToDto(array $request, array $setProperties = [])
    {
        return $this->withProperties((object)$request, $setProperties);
    }
}
