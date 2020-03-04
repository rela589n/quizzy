<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AskedQuestion
 *
 * @property int $id
 * @property int $test_result_id
 * @property int $question_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Answer[] $answers
 * @property-read int|null $answers_count
 * @property-read \App\Models\TestResult $testResult
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AskedQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AskedQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AskedQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AskedQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AskedQuestion whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AskedQuestion whereTestResultId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Question $question
 */
class AskedQuestion extends Model
{
    public $timestamps = false;

    protected $fillable = ['question_id'];

    public function testResult()
    {
        return $this->belongsTo(TestResult::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
