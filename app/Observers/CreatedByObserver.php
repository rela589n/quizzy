<?php

namespace App\Observers;


use App\Models\Administrator;
use Illuminate\Database\Eloquent\Model;

class CreatedByObserver
{
    private ?Administrator $user;

    public function __construct(?Administrator $user)
    {
        $this->user = $user;
    }

    public function creating(Model $model): void
    {
        $model->created_by = optional($this->user)->id;
    }
}
