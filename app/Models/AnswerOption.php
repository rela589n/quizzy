<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AnswerOption onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AnswerOption whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AnswerOption withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AnswerOption withoutTrashed()
 */
class AnswerOption extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    public $guarded = ['id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
