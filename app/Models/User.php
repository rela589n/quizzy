<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User
 *
 * @property int $student_group_id
 * @property-read StudentGroup $studentGroup
 * @method static Builder|User whereStudentGroupId($value)
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
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePasswordChanged($value)
 * @method static Builder|User wherePatronymic($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereSurname($value)
 * @method static Builder|User whereUpdatedAt($value)
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|TestResult
     */
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
