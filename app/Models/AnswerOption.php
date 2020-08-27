<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Carbon;

/**
 * App\Models\AnswerOption
 *
 * @property int $id
 * @property string $text
 * @property int $question_id
 * @property int $is_right
 * @property-read Question $question
 * @method static EloquentBuilder|AnswerOption newModelQuery()
 * @method static EloquentBuilder|AnswerOption newQuery()
 * @method static EloquentBuilder|AnswerOption query()
 * @method static EloquentBuilder|AnswerOption whereId($value)
 * @method static EloquentBuilder|AnswerOption whereIsRight($value)
 * @method static EloquentBuilder|AnswerOption whereQuestionId($value)
 * @method static EloquentBuilder|AnswerOption whereText($value)
 * @mixin Eloquent
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static QueryBuilder|AnswerOption onlyTrashed()
 * @method static bool|null restore()
 * @method static EloquentBuilder|AnswerOption whereDeletedAt($value)
 * @method static QueryBuilder|AnswerOption withTrashed()
 * @method static QueryBuilder|AnswerOption withoutTrashed()
 */
class AnswerOption extends Model
{
    use SoftDeletes;
    public $timestamps = false;

    protected $fillable = ['text', 'question_id', 'is_right'];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
