<?php


namespace App\Http\Requests\Groups;

use App\Http\Requests\RequestUrlManager;
use App\Models\Administrator;
use App\Rules\Containers\GroupRulesContainer;
use Illuminate\Validation\Rule;

final class UpdateGroupRequest extends GroupRequest
{
    public function authorize(Administrator $administrator, RequestUrlManager $urlManager): bool
    {
        return $administrator->can('update', $urlManager->getCurrentGroup());
    }

    public function rules(GroupRulesContainer $rulesContainer, RequestUrlManager $urlManager): array
    {
        return $rulesContainer->updateRules($urlManager->getCurrentGroup());
    }
}
