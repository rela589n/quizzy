<?php

namespace App\Http\Requests\Subjects;


use App\Models\Administrator;
use App\Rules\Containers\SubjectRulesContainer;
use Illuminate\Foundation\Http\FormRequest;

final class CreateSubjectRequest extends FormRequest
{
    public function authorize(Administrator $user): bool
    {
        return $user->can('create-subjects');
    }

    public function rules(SubjectRulesContainer $rulesContainer): array
    {
        $rules = $rulesContainer->getRules();
        $rules['uri_alias'][] = 'unique:test_subjects';

        return $rules;
    }
}
