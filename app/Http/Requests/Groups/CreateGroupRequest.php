<?php

namespace App\Http\Requests\Groups;


use App\Models\Administrator;
use App\Rules\Containers\GroupRulesContainer;

final class CreateGroupRequest extends GroupRequest
{
    public function authorize(Administrator $user): bool
    {
        return $user->can('create-groups');
    }

    public function rules(GroupRulesContainer $rulesContainer): array
    {
        $rules = $rulesContainer->getRules();
        $rules['uri_alias'][] = 'unique:student_groups';

        return $rules;
    }
}
