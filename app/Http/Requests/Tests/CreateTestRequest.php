<?php

namespace App\Http\Requests\Tests;


class CreateTestRequest extends TestRequest
{
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
