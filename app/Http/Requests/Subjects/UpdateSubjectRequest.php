<?php

namespace App\Http\Requests\Subjects;

use App\Http\Requests\RequestUrlManager;
use App\Models\Administrator;
use App\Rules\Containers\SubjectRulesContainer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateSubjectRequest extends FormRequest
{
    public function authorize(Administrator $user, RequestUrlManager $urlManager): bool
    {
        return $user->can('update', $urlManager->getCurrentSubject());
    }

    public function rules(SubjectRulesContainer $rulesContainer, RequestUrlManager $urlManager): array
    {
        $rules = $rulesContainer->getRules();

        $rules['uri_alias'][] = Rule::unique('test_subjects')
            ->ignoreModel($urlManager->getCurrentSubject());

        return $rules;
    }
}
