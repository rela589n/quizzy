<?php


namespace App\Http\Requests\Groups;


use App\Http\Requests\RequestUrlManager;
use App\Models\Administrator;
use App\Rules\Containers\GroupRulesContainer;
use Illuminate\Validation\Rule;

final class UpdateGroupRequest extends GroupRequest
{
    /**
     * Determine if the user can update group.
     *
     * @param Administrator $administrator
     * @param RequestUrlManager $urlManager
     * @return bool
     */
    public function authorize(Administrator $administrator, RequestUrlManager $urlManager)
    {
        return $administrator->can('update', $urlManager->getCurrentGroup());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param GroupRulesContainer $rulesContainer
     * @param RequestUrlManager $urlManager
     * @return array
     */
    public function rules(GroupRulesContainer $rulesContainer, RequestUrlManager $urlManager)
    {
        $rules = $rulesContainer->getRules();

        $rules['uri_alias'][] = Rule::unique('student_groups')
            ->ignoreModel($urlManager->getCurrentGroup());

        return $rules;
    }
}
