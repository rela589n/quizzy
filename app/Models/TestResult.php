<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TestResult
 *
 * @property int $id
 * @property int|null $test_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\Test|null $test
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestResult whereTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestResult whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AskedQuestion[] $askedQuestions
 * @property-read int|null $asked_questions_count
 * @property-read \App\Models\User|null $user
 */
class TestResult extends Model
{
    public const UPDATED_AT = null;

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function askedQuestions()
    {
        return $this->hasMany(AskedQuestion::class);
    }
}
