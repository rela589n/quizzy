<?php

namespace App\Models;

use App\Lib\Traits\FilteredScope;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Department
 *
 * @property int $id
 * @property string $name
 * @property string $uri_alias
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereUriAlias($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|StudentGroup[] $studentGroups
 * @property-read int|null $student_groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection|TestSubject[] $testSubjects
 * @property-read int|null $test_subjects_count
 * @method static \Illuminate\Database\Eloquent\Builder|Department filtered(\App\Lib\Filters\Eloquent\ResultFilter $filters)
 * @method static \Illuminate\Database\Query\Builder|Department onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Department withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Department withoutTrashed()
 */
class Department extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use FilteredScope;

    public $timestamps = false;
    protected $fillable = ['name', 'uri_alias'];

    public function testSubjects()
    {
        return $this->belongsToMany(TestSubject::class);
    }

    public function studentGroups()
    {
        return $this->hasMany(StudentGroup::class);
    }
}
