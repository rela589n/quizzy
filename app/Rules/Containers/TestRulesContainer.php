<?php


namespace App\Rules\Containers;


use App\Rules\MarkPercentMap;
use App\Rules\UriSlug;
use Illuminate\Validation\Rules\In;

final class TestRulesContainer
{
    public function getRules()
    {
        return [
            'name'      => [
                'required',
                'min:3',
                'max:128',
            ],
            'uri_alias' => [
                'required',
                'min:3',
                'max:48',
                new UriSlug()
            ],
            'time'      => [
                'required',
                'numeric',
                'min:1',
                'max:65000'
            ],

            'mark_evaluator_type' => [
                'required',
                'string',
                new In(['default', 'custom'])
            ],

            'correlation_table'           => [
                'required_if:mark_evaluator_type,custom',
                'array',
                'min:3',
                new MarkPercentMap()
            ],

            'correlation_table.*.mark'    => [
                'bail',
                'required',
                'integer',
                'distinct',
                'min:1',
            ],
            'correlation_table.*.percent' => [
                'bail',
                'required',
                'numeric',
                'distinct',
                'between:0,100',
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
