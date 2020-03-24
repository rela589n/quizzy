<?php

namespace App\Http\Requests\Tests;


class CreateTestRequest extends MakeTestRequest
{
    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return $this->user('admin')->can('create-tests');
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
