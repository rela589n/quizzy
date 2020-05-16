<?php


namespace App\Rules\Containers;


use App\Rules\UriSlug;

class TestRulesContainer
{
    public function getRules()
    {
        return [
            'name'            => [
                'required',
                'min:3',
                'max:128',
                new UriSlug()
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
}
