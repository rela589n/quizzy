<?php

namespace App\Http\Requests\Groups;


class CreateGroupRequest extends GroupRequest
{
    /**
     * Determine if the user can create group.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('admin')->can('create-groups');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['uri_alias'][] = 'unique:student_groups';
        return $rules;
    }
}
