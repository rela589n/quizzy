<?php

namespace App\Http\Requests\Subjects;

use App\TestSubject;
use Illuminate\Validation\Rule;

class UpdateSubjectRequest extends BaseSubjectRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $subject = TestSubject::where('uri_alias', '=', $this->route('subject'))->first();
        $rules['uri_alias'][] = Rule::unique('test_subjects')->ignoreModel($subject);

        return $rules;
    }
}
