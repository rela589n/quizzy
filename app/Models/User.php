<?php

namespace App\Models;

/**
 * App\Models\User
 * @property int $student_group_id
 * @property-read StudentGroup $studentGroup
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStudentGroupId($value)
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
}
