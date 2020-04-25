<?php


namespace App\Lib\Traits;


use Illuminate\Database\Eloquent\Model;

trait OwnerChecks
{
    /**
     * @param Model $model
     * @return bool
     */
    public function isOwnedBy(Model $model)
    {
        return $model->id == $this->created_by;
    }
}
