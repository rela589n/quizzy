<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property string $question
 * @property int $test_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AnswerOption[] $answerOptions
 * @property-read int|null $answer_options_count
 * @property-read Test $test
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereTestId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question random($limit)
 */
class Question extends Model
{
    public $timestamps = false;
    public $guarded = ['id'];

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
