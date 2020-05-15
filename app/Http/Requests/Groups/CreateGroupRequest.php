<?php

namespace App\Http\Requests\Groups;


use App\Models\Administrator;
use App\Rules\Containers\GroupRulesContainer;

final class CreateGroupRequest extends GroupRequest
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
     * @param GroupRulesContainer $rulesContainer
     * @return array
     */
    public function rules(GroupRulesContainer $rulesContainer)
    {
        $rules = $rulesContainer->getRules();
        $rules['uri_alias'][] = 'unique:student_groups';

        return $rules;
    }
}
