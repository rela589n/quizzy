<?php

namespace App\Http\Requests\Subjects;


class CreateSubjectRequest extends SubjectPostRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['uri_alias'][] = 'unique:test_subjects';
        return $rules;
    }
}
