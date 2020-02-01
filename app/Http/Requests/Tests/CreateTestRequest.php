<?php

namespace App\Http\Requests\Tests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTestRequest extends TestRequest
{
    public function rules()
    {
        $rules = $this->baseRules;
        $rules['uri_alias'][] = 'unique:tests';
        return $rules;
    }
}
