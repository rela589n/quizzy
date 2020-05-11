<?php

namespace App\Http\Requests\Departments;

use App\Http\Requests\RequestUrlManager;
use App\Models\Administrator;
use App\Rules\Containers\DepartmentRulesContainer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
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
        return $user->can('update', $urlManager->getCurrentDepartment());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param DepartmentRulesContainer $rules
     * @param RequestUrlManager $urlManager
     * @return array
     */
    public function rules(DepartmentRulesContainer $rules, RequestUrlManager $urlManager)
    {
        $rules = $rules->getRules();

        $rules['uri_alias'][] = Rule::unique('departments')
            ->ignoreModel($urlManager->getCurrentDepartment());;

        return $rules;
    }
}
