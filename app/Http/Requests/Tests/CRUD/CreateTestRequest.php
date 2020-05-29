<?php

namespace App\Http\Requests\Tests\CRUD;


use App\Models\Administrator;
use App\Rules\Containers\TestRulesContainer;

final class CreateTestRequest extends TestRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Administrator $user
     * @return bool
     */
    public function authorize(Administrator $user)
    {
        return $user->can('create-tests');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param TestRulesContainer $rulesContainer
     * @return array
     */
    public function rules(TestRulesContainer $rulesContainer)
    {
        $rules = $rulesContainer->getRules();
        $rules['uri_alias'][] = 'unique:tests';

        return $rules;
    }
}
