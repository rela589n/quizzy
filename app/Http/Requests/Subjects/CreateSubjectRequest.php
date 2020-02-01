<?php

namespace App\Http\Requests\Subjects;


class CreateSubjectRequest extends SubjectRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->baseRules;
        $rules['uri_alias'][] = 'unique:test_subjects';
        return $rules;
    }
}
