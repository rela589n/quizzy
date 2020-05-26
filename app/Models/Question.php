<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property string $question
 * @property int $test_id
 * @property-read \Illuminate\Database\Eloquent\Collection|AnswerOption[] $answerOptions
 * @property-read int|null $answer_options_count
 * @property-read Test $test
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereTestId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Question random($limit)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Question onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Question withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Question withoutTrashed()
 */
class Question extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    public $fillable = ['question', 'test_id'];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function answerOptions()
    {
        return $this->hasMany(AnswerOption::class);
    }

    /**
     * Scope a query to include random <b>$limit</b> questions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRandom($query, $limit)
    {
        return $query->inRandomOrder()->limit($limit);
    }
}
