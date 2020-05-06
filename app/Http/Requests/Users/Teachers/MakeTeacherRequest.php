<?php


namespace App\Http\Requests\Users\Teachers;


use App\Http\Requests\Users\MakeUserRequest;
use App\Lib\ValidationGenerator;

abstract class MakeTeacherRequest extends MakeUserRequest
{
    /**
     * @var ValidationGenerator
     */
    protected $validationGenerator;

    public function attributes()
    {
        $attributes = parent::attributes();

        $attributes += $this->validationGenerator->buildAttribute('role_ids.*', '"Ролі"');

        return $attributes;
    }

    public function rules(ValidationGenerator $generator)
    {
        $this->validationGenerator = $generator;

        $rules = parent::rules($generator);

        $rules += $generator->buildRule('role_ids', 'required|array|min:1');
        $rules += $generator->buildRule('role_ids.*', 'numeric|exists:roles,id');

        return $rules;
    }
}
