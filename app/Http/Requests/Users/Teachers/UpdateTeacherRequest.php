<?php


namespace App\Http\Requests\Users\Teachers;


use App\Lib\ValidationGenerator;
use App\Models\Administrator;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends MakeTeacherRequest
{
    private $administrator;

    public function administrator()
    {
        return singleVar($this->administrator, function () {
            return Administrator::findOrFail($this->route('teacherId'));
        });
    }

    public function authorize(Administrator $user)
    {
        return $user->can('update', $this->administrator());
    }

    public function rules(ValidationGenerator $generator)
    {
        $rules = parent::rules($generator);
        $rules[$this->username()][] = Rule::unique('administrators')->ignore($this->route('teacherId'));
        $rules['password'][] = 'nullable';

        return $rules;
    }
}
