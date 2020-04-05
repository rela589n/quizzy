<?php

namespace App\Models;

use App\Lib\Traits\FilteredScope;
use App\Lib\Traits\SlugScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

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
 * @property-read int $course
 * @property int|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentGroup whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentGroup whereSlug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentGroup filtered(\App\Lib\Filters\Eloquent\ResultFilter $filters)
 */
class StudentGroup extends Model
{
    use SoftDeletes;
    use HasRelationships;

    use SlugScope;
    use FilteredScope;

    public $timestamps = false;

    protected $fillable = ['name', 'uri_alias', 'year'];
    protected $studyStartMonth = 9;
    protected $studyStartDay = 1;

    public function students()
    {
        return $this->hasMany(User::class)->orderBy('surname')->orderBy('name');
    }

    /**
     * Get the group's course.
     *
     * @return int
     */
    public function getCourseAttribute()
    {
        $started = Carbon::parse(
            sprintf('%s-%s-%s',
                $this->year,
                $this->studyStartMonth,
                $this->studyStartDay)
        );

        return Carbon::now()->diffInYears($started) + 1;
    }

    public function lastResults($test)
    {
        $students = $this->students;
        $builder = clone $students[0]->lastResultOf($test);

        for ($i = 1; $i < $students->count(); ++$i) {
            $builder->union($students[$i]->lastResultOf($test));
        }

        return $builder;
    }
}
