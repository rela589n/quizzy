<?php

namespace App\Http\Requests\Tests\CRUD;


use App\Http\Requests\RequestUrlManager;
use App\Models\Administrator;
use App\Rules\Containers\TestRulesContainer;
use Illuminate\Validation\Rule;

final class UpdateTestRequest extends TestRequest
{
    public function authorize(Administrator $user, RequestUrlManager $urlManager): bool
    {
        return $user->can('update', $urlManager->getCurrentTest());
    }

    public function rules(TestRulesContainer $rulesContainer, RequestUrlManager $urlManager): array
    {
        $rules = $rulesContainer->getRules();
        $rules['uri_alias'][] = Rule::unique('tests')
            ->ignoreModel($urlManager->getCurrentTest());

        return $rules;
    }
}
