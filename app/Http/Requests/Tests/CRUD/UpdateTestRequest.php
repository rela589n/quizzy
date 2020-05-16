<?php

namespace App\Http\Requests\Tests\CRUD;


use App\Http\Requests\RequestUrlManager;
use App\Models\Administrator;
use App\Rules\Containers\TestRulesContainer;
use Illuminate\Validation\Rule;

class UpdateTestRequest extends MakeTestRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Administrator $user
     * @param RequestUrlManager $urlManager
     * @return bool
     */
    public function authorize(Administrator $user, RequestUrlManager $urlManager)
    {
        return $user->can('update', $urlManager->getCurrentTest());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param TestRulesContainer $rulesContainer
     * @param RequestUrlManager $urlManager
     * @return array
     */
    public function rules(TestRulesContainer $rulesContainer, RequestUrlManager $urlManager)
    {
        $rules = $rulesContainer->getRules();
        $rules['uri_alias'][] = Rule::unique('tests')
            ->ignoreModel($urlManager->getCurrentTest());

        return $rules;
    }
}
