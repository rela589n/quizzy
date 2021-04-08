<?php


namespace App\Rules\Containers;


use App\Rules\Containers\Test\TestGradingTableRules;
use App\Rules\Containers\Test\TestMarkEvaluatorTypeRules;
use App\Rules\Containers\Test\TestNameRules;
use App\Rules\Containers\Test\TestPassTimeRules;
use App\Rules\Containers\Test\TestUriSlugRules;

final class TestRulesContainer
{
    public function getRules(): array
    {
        return [
            'name'      => app()->make(TestNameRules::class)->build(),
            'uri_alias' => app()->make(TestUriSlugRules::class)->build(),
            'time'      => app()->make(TestPassTimeRules::class)->build(),

            'mark_evaluator_type' => app()->make(TestMarkEvaluatorTypeRules::class)->build(),

            'correlation_table' => app()->make(TestGradingTableRules::class)->build(),

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
