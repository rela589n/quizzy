<?php


namespace App\Http\Requests\Users\Students;


use App\Lib\ValidationGenerator;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends MakeStudentRequest
{
    protected $validateGroup = true;

    public function authorize()
    {
        return $this->user('admin')->can('update-students');
    }

    public function rules(ValidationGenerator $generator)
    {
        $rules = parent::rules($generator);

        $rules[$this->username()][] = Rule::unique('users')->ignore($this->route('studentId'));
        $rules['password'][] = 'nullable';

        return $rules;
    }
}
