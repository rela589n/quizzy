<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\AnswerOption
 *
 * @property int $id
 * @property string $text
 * @property int $question_id
 * @property int $is_right
 * @property-read Question $question
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerOption whereIsRight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerOption whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerOption whereText($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|AnswerOption onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerOption whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|AnswerOption withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AnswerOption withoutTrashed()
 */
class AnswerOption extends Model
{
    use SoftDeletes;
    public $timestamps = false;

    protected $fillable = ['text', 'question_id', 'is_right'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
