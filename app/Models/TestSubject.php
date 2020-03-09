<?php

namespace App\Models;

use App\Lib\Traits\LoadTrashed;
use App\Models\Test;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TestSubject
 *
 * @property int $id
 * @property string $name
 * @property string $uri_alias
 * @property string $course
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Test[] $tests
 * @property-read int|null $tests_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject whereCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestSubject whereUriAlias($value)
 * @mixin \Eloquent
 */
class TestSubject extends Model
{
    use LoadTrashed;

    public $timestamps = false;
    protected $fillable = ['name', 'uri_alias', 'course'];

    public function tests()
    {
        return $this->hasMany(Test::class);
    }
}
