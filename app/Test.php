<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Test
 *
 * @property int $id
 * @property string $name
 * @property string $uri_alias
 * @property int $time
 * @property int $test_subject_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[] $nativeQuestions
 * @property-read int|null $native_questions_count
 * @property-read \App\TestSubject $subject
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Test[] $tests
 * @property-read int|null $tests_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test whereTestSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test whereUriAlias($value)
 * @mixin \Eloquent
 */
class Test extends Model
{
    public $timestamps = false;
    protected $fillable = []; // todo create architecture

    public function subject()
    {
        return $this->belongsTo(TestSubject::class, 'test_subject_id');
    }

    public function nativeQuestions()
    {
        return $this->hasMany(Question::class);
    }

    public function tests() // todo may be changed to Has Many Through relation
    {
        return $this->belongsToMany(
            self::class,
            'test_composite',
            'id_test',
            'id_include_test'
        );
    }
}
