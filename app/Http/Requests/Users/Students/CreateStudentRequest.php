<?php


namespace App\Http\Requests\Users\Students;

use App\Lib\ValidationGenerator;
use App\Models\Administrator;

class CreateStudentRequest extends MakeStudentRequest
{
    /**
     * @inheritDoc
     */
    public function authorize(Administrator $user)
    {
        return $user->can('create-students');
    }

    public function rules(ValidationGenerator $generator)
    {
        $rules = parent::rules($generator);
        $rules[$this->username()][] = 'unique:users';
        return $rules;
    }
}
