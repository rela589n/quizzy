<?php

namespace App\Http\Requests\Departments;

use App\Http\Requests\RequestUrlManager;
use App\Models\Administrator;
use App\Rules\Containers\DepartmentRulesContainer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(
        Administrator $user,
        RequestUrlManager $urlManager
    ): bool {
        return $user->can('update', $urlManager->getCurrentDepartment());
    }

    public function rules(
        DepartmentRulesContainer $rules,
        RequestUrlManager $urlManager
    ): array {
        $rules = $rules->getRules();

        $rules['uri_alias'][] = Rule::unique('departments')
            ->ignoreModel($urlManager->getCurrentDepartment());

        $rules['name'][] = Rule::unique('departments')
            ->ignoreModel($urlManager->getCurrentDepartment());

        return $rules;
    }
}
