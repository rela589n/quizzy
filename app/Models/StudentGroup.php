<?php

namespace App\Models;

use App\Lib\Traits\FilteredScope;
use App\Lib\Traits\OwnerChecks;
use App\Lib\Traits\SlugScope;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\StudentGroup
 *
 * @property int $id
 * @property string $name
 * @property string $uri_alias
 * @property int $year
 * @property Carbon|null $deleted_at
 * @property-read Collection|User[] $students
 * @property-read int|null $students_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup newQuery()
 * @method static \Illuminate\Database\Query\Builder|StudentGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup whereUriAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup whereYear($value)
 * @method static \Illuminate\Database\Query\Builder|StudentGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|StudentGroup withoutTrashed()
 * @mixin \Eloquent
 * @property-read int $course
 * @property int|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup whereSlug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup filtered(\App\Lib\Filters\Eloquent\ResultFilter $filters)
 * @property int|null $department_id
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup whereDepartmentId($value)
 * @property-read Department|null $department
 * @property-read Administrator|null $classMonitor
 */
class StudentGroup extends Model
{
    use SoftDeletes;

    use SlugScope;
    use FilteredScope;

    use OwnerChecks;

    public $timestamps = false;

    protected $fillable = ['name', 'uri_alias', 'year', 'created_by'];
    protected $studyStartMonth = 9;
    protected $studyStartDay = 1;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|User
     */
    public function students()
    {
        return $this->hasMany(User::class)->orderBy('surname')->orderBy('name');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Administrator
     */
    protected function administrator()
    {
        return $this->belongsTo(Administrator::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder|Administrator
     */
    public function classMonitor()
    {
        return $this->administrator()->ofRole('class-monitor');
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

    public function lastResults(Test $test)
    {
        /**
         * @var $students Collection|User[]
         */
        $students = $this->students()->withTrashed()->get();
        $builder = clone $students[0]->lastResultOf($test);

        for ($i = 1; $i < $students->count(); ++$i) {
            $builder->union($students[$i]->lastResultOf($test)->toBase());
        }

        return $builder;
    }
}
