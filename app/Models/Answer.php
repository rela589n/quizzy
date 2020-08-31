<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Answer
 *
 * @property int $id
 * @property int $answer_option_id
 * @property int $asked_question_id
 * @property int $is_chosen
 * @property-read AskedQuestion $askedQuestion
 * @method static Builder|Answer newModelQuery()
 * @method static Builder|Answer newQuery()
 * @method static Builder|Answer query()
 * @method static Builder|Answer whereAnswerOptionId($value)
 * @method static Builder|Answer whereAskedQuestionId($value)
 * @method static Builder|Answer whereId($value)
 * @method static Builder|Answer whereIsChosen($value)
 * @mixin Eloquent
 * @property-read AnswerOption $answerOption
 */
class Answer extends Model
{
    public $timestamps = false;

    protected $fillable = ['is_chosen', 'answer_option_id'];

    public function askedQuestion(): BelongsTo
    {
        return $this->belongsTo(AskedQuestion::class);
    }

    public function answerOption(): BelongsTo
    {
        return $this->belongsTo(AnswerOption::class);
    }
}
