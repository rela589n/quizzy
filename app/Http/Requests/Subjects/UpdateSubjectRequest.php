<?php

namespace App\Http\Requests\Subjects;

use App\Http\Requests\RequestUrlManager;
use App\Models\Administrator;
use App\Rules\Containers\SubjectRulesContainer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubjectRequest extends FormRequest
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
        return $user->can('update', $urlManager->getCurrentSubject());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param SubjectRulesContainer $rulesContainer
     * @param RequestUrlManager $urlManager
     * @return array
     */
    public function rules(SubjectRulesContainer $rulesContainer, RequestUrlManager $urlManager)
    {
        $rules = $rulesContainer->getRules();

        $rules['uri_alias'][] = Rule::unique('test_subjects')
            ->ignoreModel($urlManager->getCurrentSubject());

        return $rules;
    }
}
