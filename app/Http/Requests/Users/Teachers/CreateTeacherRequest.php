<?php


namespace App\Http\Requests\Users\Teachers;


use App\Lib\ValidationGenerator;
use App\Models\Administrator;

class CreateTeacherRequest extends MakeTeacherRequest
{
    public function authorize(Administrator $user)
    {
        return $user->can('create-administrators');
    }

    public function rules(ValidationGenerator $generator)
    {
        $rules = parent::rules($generator);
        $rules[$this->username()][] = 'unique:administrators';
        return $rules;
    }
}
