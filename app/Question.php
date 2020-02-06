<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Question
 *
 * @property int $id
 * @property string $question
 * @property int $test_id
 * @property-read \App\Test $test
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereTestId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AnswerOption[] $answerOptions
 * @property-read int|null $answer_options_count
 */
class Question extends Model
{
    public $guarded = ['id'];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function answerOptions()
    {
        return $this->hasMany(AnswerOption::class);
    }
}
