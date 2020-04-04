<?php

namespace App\Http\Requests\Tests;


use App\Http\Requests\RequestUrlManager;
use App\Models\Administrator;
use Illuminate\Validation\Rule;

class UpdateTestRequest extends MakeTestRequest
{
    /**
     * @inheritDoc
     */
    public function authorize(Administrator $user)
    {
        return $user->can('update-tests');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param RequestUrlManager $urlManager
     * @return array
     */
    public function rules(RequestUrlManager $urlManager)
    {
        $rules = $this->baseRules;
        $rules['uri_alias'][] = Rule::unique('tests')
            ->ignoreModel($urlManager->getCurrentTest());

        return $rules;
    }
}
