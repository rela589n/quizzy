<?php

namespace App\Http\Requests\Tests\CRUD;


use App\Models\Administrator;

class CreateTestRequest extends MakeTestRequest
{
    /**
     * @inheritDoc
     */
    public function authorize(Administrator $user)
    {
        return $user->can('create-tests');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->baseRules;
        $rules['uri_alias'][] = 'unique:tests';
        return $rules;
    }
}
