<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TestSubject
 *
 * @property int $id
 * @property string $name
 * @property string $uri_alias
 * @property string $course
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TestSubject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TestSubject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TestSubject query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TestSubject whereCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TestSubject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TestSubject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TestSubject whereUriAlias($value)
 * @mixin \Eloquent
 */
class TestSubject extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'uri_alias', 'course'];

    public function tests()
    {
        return $this->hasMany(Test::class, 'id_subject');
    }
}
