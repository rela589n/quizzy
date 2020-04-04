<?php

namespace App\Http\Requests\Users\Students;


use App\Http\Requests\Users\MakeUserRequest;
use App\Lib\ValidationGenerator;
use App\Models\User;

abstract class StudentRequest extends MakeUserRequest
{
    protected $validateGroup = false;

    private $student;

    public function student()
    {
        return singleVar($this->student, function () {
            return User::findOrFail($this->route('studentId'));
        });
    }

    public function rules(ValidationGenerator $generator)
    {
        $rules = parent::rules($generator);

        if ($this->validateGroup) {
            $rules['student_group_id'] = [
                'required',
                'numeric'
            ];
        }

        return $rules;
    }
}
