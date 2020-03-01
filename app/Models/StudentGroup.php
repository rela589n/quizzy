<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\StudentGroup
 *
 * @property int $id
 * @property string $name
 * @property string $uri_alias
 * @property int $year
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $students
 * @property-read int|null $students_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentGroup newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentGroup query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentGroup whereUriAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentGroup whereYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentGroup withoutTrashed()
 * @mixin \Eloquent
 */
class StudentGroup extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable = ['name', 'uri_alias', 'year'];

    public function students()
    {
        return $this->hasMany(User::class);
    }
}
