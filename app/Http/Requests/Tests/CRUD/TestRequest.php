<?php


namespace App\Http\Requests\Tests\CRUD;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class TestRequest extends FormRequest
{
    public function attributes(): array
    {
        return ['custom' => trans('validation.attributes.custom')];
    }

    protected function failedValidation(Validator $validator): void
    {
        \Session::push('messageToUser', trans('validation.custom.some_configurations_have_errors'));

        parent::failedValidation($validator);
    }
}
