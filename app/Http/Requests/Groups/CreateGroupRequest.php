<?php

namespace App\Http\Requests\Groups;


use App\Models\Administrator;

class CreateGroupRequest extends GroupRequest
{
    /**
     * Determine if the user can create group.
     *
     * @param Administrator $user
     * @return bool
     */
    public function authorize(Administrator $user)
    {
        return $user->can('create-groups');
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
