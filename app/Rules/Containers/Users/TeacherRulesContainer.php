<?php


namespace App\Rules\Containers\Users;


final class TeacherRulesContainer extends UserRulesContainer
{
    public function getRules(): array
    {
        $rules = parent::getRules();

        $rules += $this->validationGenerator->buildRule('role_ids', 'required|array|min:1');
        $rules += $this->validationGenerator->buildRule('role_ids.*', 'numeric|exists:roles,id');

        return $rules;
    }

    public function getAttributes()
    {
        return $this->validationGenerator->buildAttribute('role_ids.*', trans('validation.attributes.roles'));
    }
}
