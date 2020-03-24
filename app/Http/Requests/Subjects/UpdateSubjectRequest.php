<?php

namespace App\Http\Requests\Subjects;

use App\Http\Requests\UrlManageable;
use App\Http\Requests\UrlManageableRequests;
use Illuminate\Validation\Rule;

class UpdateSubjectRequest extends SubjectRequest implements UrlManageable
{
    use UrlManageableRequests;

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return $this->user('admin')->can('update-subjects');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules['uri_alias'][] = Rule::unique('test_subjects')
            ->ignoreModel($this->urlManager->getCurrentSubject());

        return $rules;
    }

}
