<?php


namespace App\Http\Requests\Users\Students;

use App\Http\Requests\Users\MakeUserRequest;
use App\Lib\ValidationGenerator;
use App\Models\Administrator;

class CreateStudentRequest extends MakeUserRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Administrator $user
     * @return bool
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
