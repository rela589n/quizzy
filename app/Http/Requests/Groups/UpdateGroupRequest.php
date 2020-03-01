<?php


namespace App\Http\Requests\Groups;


use App\Http\Requests\UrlManageable;
use App\Http\Requests\UrlManageableRequests;
use Illuminate\Validation\Rule;

class UpdateGroupRequest extends GroupRequest implements UrlManageable
{
    use UrlManageableRequests;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules['uri_alias'][] = Rule::unique('test_subjects')
            ->ignoreModel($this->urlManager->getCurrentGroup());

        return $rules;
    }
}