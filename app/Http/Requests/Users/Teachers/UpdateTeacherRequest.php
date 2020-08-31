<?php


namespace App\Http\Requests\Users\Teachers;


use App\Models\Administrator;
use App\Rules\Containers\Users\TeacherRulesContainer;
use Illuminate\Validation\Rule;

final class UpdateTeacherRequest extends TeacherRequest
{
    private TeacherRulesContainer $rulesContainer;
    private ?Administrator $administrator = null;

    public function administrator(): Administrator
    {
        return singleVar(
            $this->administrator,
            function () {
                return Administrator::findOrFail($this->route('teacherId'));
            }
        );
    }

    public function authorize(Administrator $user): bool
    {
        return $user->can('update', $this->administrator());
    }

    public function rules(TeacherRulesContainer $container): array
    {
        $this->rulesContainer = $container;

        $rules = $container->getRules();
        $rules[$container->usernameAttr()][] = Rule::unique('administrators')
            ->ignoreModel($this->administrator());
        $rules[$container->passwordAttr()][] = 'nullable';

        return $rules;
    }

    protected function getRulesContainer(): TeacherRulesContainer
    {
        return $this->rulesContainer;
    }
}
