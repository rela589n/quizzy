<?php

namespace App\Http\Requests\Subjects;


use App\Models\Administrator;

class CreateSubjectRequest extends SubjectRequest
{
    /**
     * @inheritDoc
     */
    public function authorize(Administrator $user)
    {
        return $user->can('create-subjects');
    }

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
