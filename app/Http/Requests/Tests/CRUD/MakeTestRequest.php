<?php

namespace App\Http\Requests\Tests\CRUD;

use App\Models\Administrator;
use App\Rules\UriSlug;
use Illuminate\Foundation\Http\FormRequest;

abstract class MakeTestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Administrator $user
     * @return bool
     */
    public abstract function authorize(Administrator $user);

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->baseRules['uri_alias'][] = new UriSlug();
    }

    protected $baseRules = [
        'name'            => [
            'required',
            'min:3',
            'max:128'
        ],
        'uri_alias'       => [
            'required',
            'min:3',
            'max:48',
        ],
        'time'            => [
            'required',
            'numeric',
            'min:1',
            'max:65000'
        ],
        'include'         => 'nullable|array',
        'include.*'       => 'array',
        'include.*.count' => [
            'required_with:include.*.necessary',
            'exclude_unless:include.*.necessary,on',
            'nullable',
            'numeric',
            'min:1',
            'max:65000'
        ]
    ];
}
