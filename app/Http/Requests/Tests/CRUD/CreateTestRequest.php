<?php

namespace App\Http\Requests\Tests\CRUD;


use App\Models\Administrator;
use App\Rules\Containers\TestRulesContainer;

final class CreateTestRequest extends TestRequest
{
    public function authorize(Administrator $user): bool
    {
        return $user->can('create-tests');
    }

    public function rules(TestRulesContainer $rulesContainer): array
    {
        $rules = $rulesContainer->getRules();
        $rules['uri_alias'][] = 'unique:tests';

        return $rules;
    }
}
