<?php

namespace App\Http\Requests\Tests;

use App\Test;
use Illuminate\Foundation\Http\FormRequest;

abstract class TestRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected $baseRules = [
        'name' => [
            'required',
            'min:3',
            'max:128'
        ],
        'uri_alias' => [
            'required',
            'min:3',
            'max:48',
        ],
        'time' => [
            'required',
            'numeric',
            'min:1',
            'max:65000'
        ],
        'include' => 'nullable|array',
        'include.*' => 'array',
        'include.*.count' => [
            'required_with:include.*.necessary',
            'exclude_unless:include.*.necessary,on',
            'nullable',
            'numeric',
            'min:1'
        ]
    ];
}
