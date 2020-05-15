<?php

namespace App\Http\Requests\Departments;

use App\Models\Administrator;
use App\Rules\Containers\DepartmentRulesContainer;
use Illuminate\Foundation\Http\FormRequest;

final class CreateDepartmentsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Administrator $user
     * @return bool
     */
    public function authorize(Administrator $user)
    {
        return $user->can('create-departments');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param DepartmentRulesContainer $rules
     * @return array
     */
    public function rules(DepartmentRulesContainer $rules)
    {
        $rules = $rules->getRules();
        $rules['uri_alias'][] = 'unique:departments';

        return $rules;
    }
}
