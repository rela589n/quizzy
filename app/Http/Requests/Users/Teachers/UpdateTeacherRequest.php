<?php


namespace App\Http\Requests\Users\Teachers;


use App\Models\Administrator;
use App\Rules\Containers\Users\TeacherRulesContainer;
use Illuminate\Validation\Rule;

final class UpdateTeacherRequest extends TeacherRequest
{
    /** @var TeacherRulesContainer */
    private $rulesContainer;

    /** @var Administrator */
    private $administrator;

    /**
     * Get the Administrator instance being updated
     * @return Administrator
     */
    public function administrator(): Administrator
    {
        return singleVar($this->administrator, function () {
            return Administrator::findOrFail($this->route('teacherId'));
        });
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Administrator $user
     * @return bool
     */
    public function authorize(Administrator $user)
    {
        return $user->can('update', $this->administrator());
    }

    /**
     * Get the validation rules that apply to the request.
     * @param TeacherRulesContainer $container
     * @return array
     */
    public function rules(TeacherRulesContainer $container)
    {
        $this->rulesContainer = $container;

        $rules = $container->getRules();
        $rules[$container->usernameAttr()][] = Rule::unique('administrators')->ignoreModel($this->administrator());
        $rules[$container->passwordAttr()][] = 'nullable';

        return $rules;
    }

    protected function getRulesContainer(): TeacherRulesContainer
    {
        return $this->rulesContainer;
    }
}
