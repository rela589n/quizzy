<?php


namespace App\Http\Requests\Groups;


use App\Http\Requests\UrlManageable;
use App\Models\Administrator;
use Illuminate\Validation\Rule;

class UpdateGroupRequest extends GroupRequest implements UrlManageable
{
    /**
     * Determine if the user can update group.
     *
     * @param Administrator $administrator
     * @return bool
     */
    public function authorize(Administrator $administrator)
    {
        return $administrator->can('update', $this->studentGroup());
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
            ->ignoreModel($this->studentGroup());

        return $rules;
    }
}
