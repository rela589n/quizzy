<?php

namespace App\Http\Requests\Subjects;

use App\Http\Requests\RequestUrlManager;
use Illuminate\Validation\Rule;

class UpdateSubjectRequest extends SubjectRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @param RequestUrlManager $urlManager
     * @return array
     */
    public function rules(RequestUrlManager $urlManager)
    {
        $rules = $this->baseRules;

        $rules['uri_alias'][] = Rule::unique('test_subjects')
            ->ignoreModel($urlManager->getCurrentSubject());

        return $rules;
    }

}
