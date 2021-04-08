<?php

namespace App\Http\Requests\Departments;

use App\Models\Administrator;
use App\Rules\Containers\DepartmentRulesContainer;
use Illuminate\Foundation\Http\FormRequest;

final class CreateDepartmentsRequest extends FormRequest
{
    public function authorize(Administrator $user): bool
    {
        return $user->can('create-departments');
    }

    public function rules(DepartmentRulesContainer $rules): array
    {
        $rules = $rules->getRules();
        $rules['uri_alias'][] = 'unique:departments';
        $rules['name'][] = 'unique:departments';

        return $rules;
    }
}
