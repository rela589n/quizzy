<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Answer
 *
 * @property int $id
 * @property int $answer_option_id
 * @property int $asked_question_id
 * @property int $is_chosen
 * @property-read \App\Models\AskedQuestion $askedQuestion
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereAnswerOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereAskedQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereIsChosen($value)
 * @mixin \Eloquent
 * @property-read \App\Models\AnswerOption $answerOption
 */
class Answer extends Model
{
    public $timestamps = false;

    protected $fillable = ['is_chosen', 'answer_option_id'];

    public function askedQuestion()
    {
        return $this->belongsTo(AskedQuestion::class);
    }

    public function answerOption()
    {
        return $this->belongsTo(AnswerOption::class);
    }
}
