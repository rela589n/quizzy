<?php

namespace App\Http\Requests\Groups;


class CreateGroupRequest extends GroupRequest
{
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
