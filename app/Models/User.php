<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User
 *
 * @property int $student_group_id
 * @property-read StudentGroup $studentGroup
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStudentGroupId($value)
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int $password_changed
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $full_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePasswordChanged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePatronymic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TestResult[] $testResults
 * @property-read int|null $test_results_count
 * @property-read mixed $course
 */
class User extends BaseUser
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable[] = 'student_group_id';
    }

    public function studentGroup()
    {
        return $this->belongsTo(StudentGroup::class);
    }

    public function testResults()
    {
        return $this->hasMany(TestResult::class);
    }

    public function getCourseAttribute()
    {
        return $this->studentGroup->course;
    }

    /**
     * @param int | Test $test
     * @return Builder
     */
    public function lastResultOf($test)
    {
        return $this->testResults()->ofTest($test)->recent(1);
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function isOwnedBy(Model $model)
    {
        return $this->studentGroup->isOwnedBy($model);
    }
}
