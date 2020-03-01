<?php


namespace App\Http\Requests\Users\Students;

use App\Lib\ValidationGenerator;

class CreateStudentRequest extends MakeStudentRequest
{
    public function rules(ValidationGenerator $generator)
    {
        $rules = parent::rules($generator);
        $rules[$this->username()][] = 'unique:users';
        return $rules;
    }
}
