<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AnswerOption
 *
 * @property int $id
 * @property string $text
 * @property int $question_id
 * @property int $is_right
 * @property-read \App\Question $question
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerOption whereIsRight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerOption whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerOption whereText($value)
 * @mixin \Eloquent
 */
class AnswerOption extends Model
{
    public $guarded = ['id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
