<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Department
 *
 * @property int $id
 * @property string $name
 * @property string $uri_alias
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereUriAlias($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\StudentGroup[] $studentGroups
 * @property-read int|null $student_groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TestSubject[] $testSubjects
 * @property-read int|null $test_subjects_count
 */
class Department extends Model
{
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
