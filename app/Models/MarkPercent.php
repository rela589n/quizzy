<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MarkPercent
 *
 * @property int $id
 * @property int $mark
 * @property float $percent
 * @property int $test_id
 * @property-read Test $test
 * @method static \Illuminate\Database\Eloquent\Builder|MarkPercent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarkPercent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarkPercent query()
 * @method static \Illuminate\Database\Eloquent\Builder|MarkPercent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarkPercent whereMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarkPercent wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarkPercent whereTestId($value)
 * @mixin \Eloquent
 */
class MarkPercent extends Model
{
    public $timestamps = false;
    protected $table = 'marks_percents_map';

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
