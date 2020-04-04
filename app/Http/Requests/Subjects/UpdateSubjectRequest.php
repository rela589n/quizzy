<?php

namespace App\Http\Requests\Subjects;

use App\Http\Requests\UrlManageable;
use App\Http\Requests\UrlManageableRequests;
use App\Models\Administrator;
use Illuminate\Validation\Rule;

class UpdateSubjectRequest extends SubjectRequest implements UrlManageable
{
    use UrlManageableRequests;

    public function subject()
    {
        return $this->urlManager->getCurrentSubject();
    }

    /**
     * @inheritDoc
     */
    public function authorize(Administrator $user)
    {
        return $user->can('update', $this->subject());
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
            ->ignoreModel($this->subject());

        return $rules;
    }

}
