<?php


namespace App\Http\Requests\Users\Teachers;


use App\Lib\ValidationGenerator;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends MakeTeacherRequest
{
    public function rules(ValidationGenerator $generator)
    {
        $rules = parent::rules($generator);
        $rules[$this->username()][] = Rule::unique('administrators')->ignore($this->route('teacherId'));
        $rules['password'][] = 'nullable';

        return $rules;
    }
}
