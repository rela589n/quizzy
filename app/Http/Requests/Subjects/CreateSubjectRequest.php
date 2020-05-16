<?php

namespace App\Http\Requests\Subjects;


use App\Models\Administrator;
use App\Rules\Containers\SubjectRulesContainer;
use Illuminate\Foundation\Http\FormRequest;

final class CreateSubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Administrator $user
     * @return bool
     */
    public function authorize(Administrator $user)
    {
        return $user->can('create-subjects');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param SubjectRulesContainer $rulesContainer
     * @return array
     */
    public function rules(SubjectRulesContainer $rulesContainer)
    {
        $rules = $rulesContainer->getRules();
        $rules['uri_alias'][] = 'unique:test_subjects';

        return $rules;
    }
}
