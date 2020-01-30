<?php

namespace App\Http\Requests\Subjects;

use App\TestSubject;
use Illuminate\Validation\Rule;

class UpdateSubjectRequest extends BaseSubjectRequest
{
    protected $currentSubject = null;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $this->currentSubject = TestSubject::where('uri_alias', '=', $this->route('subject'))->first();
        $rules['uri_alias'][] = Rule::unique('test_subjects')->ignoreModel($this->currentSubject);

        return $rules;
    }

    /**
     * @return \App\TestSubject | null
     */
    public function getCurrentSubject()
    {
        return $this->currentSubject;
    }

}
