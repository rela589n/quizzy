<?php


namespace App\Http\Requests\Users\Teachers;


use App\Lib\ValidationGenerator;

class CreateTeacherRequest extends MakeTeacherRequest
{
    public function authorize()
    {
        return $this->user('admin')->can('create-administrators');
    }

    public function rules(ValidationGenerator $generator)
    {
        $rules = parent::rules($generator);
        $rules[$this->username()][] = 'unique:administrators';
        return $rules;
    }
}
