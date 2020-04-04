<?php

namespace App\Http\Requests\Tests;


use App\Http\Requests\UrlManageable;
use App\Http\Requests\UrlManageableRequests;
use App\Models\Administrator;
use Illuminate\Validation\Rule;

class UpdateTestRequest extends MakeTestRequest implements UrlManageable
{
    use UrlManageableRequests;

    /**
     * @inheritDoc
     */
    public function authorize(Administrator $user)
    {
        return $user->can('update', $this->test());
    }

    public function test()
    {
        return $this->urlManager->getCurrentTest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->baseRules;
        $rules['uri_alias'][] = Rule::unique('tests')
            ->ignoreModel($this->test());

        return $rules;
    }
}
