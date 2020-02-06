<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AnswerOption
 *
 * @property int $id
 * @property string $text
 * @property int $question_id
 * @property int $is_right
 * @property-read \App\Models\Question $question
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AnswerOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AnswerOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AnswerOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AnswerOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AnswerOption whereIsRight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AnswerOption whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AnswerOption whereText($value)
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
