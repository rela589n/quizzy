<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\MarkPercent
 *
 * @property int $id
 * @property int $mark
 * @property float $percent
 * @property int $test_id
 * @property-read Test $test
 * @method static Builder|MarkPercent newModelQuery()
 * @method static Builder|MarkPercent newQuery()
 * @method static Builder|MarkPercent query()
 * @method static Builder|MarkPercent whereId($value)
 * @method static Builder|MarkPercent whereMark($value)
 * @method static Builder|MarkPercent wherePercent($value)
 * @method static Builder|MarkPercent whereTestId($value)
 * @mixin Eloquent
 */
class MarkPercent extends Model
{
    public $timestamps = false;
    protected $table = 'marks_percents_map';

    protected $fillable = ['mark', 'percent'];

    protected $casts = [
        'mark' => 'integer',
        'percent' => 'float'
    ];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }
}
