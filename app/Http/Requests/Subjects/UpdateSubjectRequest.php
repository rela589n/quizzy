<?php

namespace App\Http\Requests\Subjects;

use App\TestSubject;
use Illuminate\Validation\Rule;

class UpdateSubjectRequest extends SubjectPostRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules['uri_alias'][] = Rule::unique('test_subjects')
            ->ignoreModel($this->getCurrentSubject());

        return $rules;
    }

}
