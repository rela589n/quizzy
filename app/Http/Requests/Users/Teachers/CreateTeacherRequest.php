<?php


namespace App\Http\Requests\Users\Teachers;


use App\Models\Administrator;
use App\Rules\Containers\Users\TeacherRulesContainer;

final class CreateTeacherRequest extends TeacherRequest
{
    protected TeacherRulesContainer $rulesContainer;

    public function authorize(Administrator $user): bool
    {
        return $user->can('create-administrators');
    }

    public function rules(TeacherRulesContainer $container): array
    {
        $this->rulesContainer = $container;

        $rules = $container->getRules();
        $rules[$container->usernameAttr()][] = 'unique:administrators';

        return $rules;
    }

    protected function getRulesContainer(): TeacherRulesContainer
    {
        return $this->rulesContainer;
    }
}
