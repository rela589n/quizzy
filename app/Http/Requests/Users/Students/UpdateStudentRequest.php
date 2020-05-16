<?php


namespace App\Http\Requests\Users\Students;


use App\Lib\ValidationGenerator;
use App\Models\Administrator;
use App\Models\User;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends StudentRequest
{
    protected $validateGroup = true;

    private $student;

    public function student()
    {
        return singleVar($this->student, function () {
            return User::findOrFail($this->route('studentId'));
        });
    }

    /**
     * @inheritDoc
     */
    public function authorize(Administrator $user)
    {
        return $user->can('update', $this->student());
    }

    public function rules(ValidationGenerator $generator)
    {
        $rules = parent::rules($generator);

        $rules[$this->username()][] = Rule::unique('users')->ignore($this->route('studentId'));
        $rules['password'][] = 'nullable';

        return $rules;
    }
}
