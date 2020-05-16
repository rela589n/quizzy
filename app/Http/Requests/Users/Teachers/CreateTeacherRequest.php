<?php


namespace App\Http\Requests\Users\Teachers;


use App\Models\Administrator;
use App\Rules\Containers\Users\TeacherRulesContainer;

final class CreateTeacherRequest extends TeacherRequest
{
    /** @var TeacherRulesContainer */
    protected $rulesContainer;

    public function authorize(Administrator $user)
    {
        return $user->can('create-administrators');
    }

    public function rules(TeacherRulesContainer $container)
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
