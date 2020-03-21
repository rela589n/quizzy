<?php


namespace App\Http\Requests\Users\Teachers;


use App\Http\Requests\Users\MakeUserRequest;
use App\Lib\ValidationGenerator;

abstract class MakeTeacherRequest extends MakeUserRequest
{
    public function rules(ValidationGenerator $generator)
    {
        $rules = parent::rules($generator);

        $rules += $generator->buildRule('role_ids', 'required|array|min:1');
        $rules += $generator->buildRule('role_ids.*', 'numeric');

        return $rules;
    }
}
