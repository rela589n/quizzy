<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkPercent extends Model
{
    public $timestamps = false;
    protected $table = 'marks_percents_map';

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
