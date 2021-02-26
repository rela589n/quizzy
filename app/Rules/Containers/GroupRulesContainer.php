<?php


namespace App\Rules\Containers;


use App\Http\Requests\RequestUrlManager;
use App\Models\Administrator;
use App\Models\StudentGroup;
use App\Rules\Containers\Group\GroupNameRules;
use App\Rules\Containers\Group\GroupUriSlugRules;
use App\Rules\Containers\Group\GroupYearRules;
use App\Rules\UriSlug;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class GroupRulesContainer
{
    private RequestUrlManager $urlManager;

    public function __construct(RequestUrlManager $urlManager)
    {
        $this->urlManager = $urlManager;
    }

    public function creationRules(): array
    {
        $rules = $this->commonRules();

        $rules['year'][] = GroupYearRules::forCreate();

        return $rules;
    }

    public function updateRules(StudentGroup $group): array
    {
        $rules = $this->commonRules();

        $rules['year'][] = 'min:'.min(date('Y') - 4, $group->year);
        $rules['uri_alias']['uniqueness']->ignoreModel($group);
        $rules['name']['uniqueness']->ignoreModel($group);

        return $rules;
    }

    public function commonRules(): array
    {
        return [
            'uri_alias'  => (GroupUriSlugRules::forCreate())->build(),
            'name'       => (GroupNameRules::forCreate())->build(),
            'created_by' => [
                'sometimes',
                'nullable',
                'integer',
                'min:1',
                "exists:".Administrator::class.",id",
            ],
            'year'       => (new GroupYearRules())->build(),
        ];
    }

    public function getRules(): array
    {
        $currentYear = date('Y');

        try {
            $currentGroup = $this->urlManager->getCurrentGroup();

            $groupYear = $currentGroup->year;
        } catch (ModelNotFoundException $e) {
            $groupYear = $currentYear;
        }

        return [
            'name'       => [
                'required',
                'min:4',
                'max:32'
            ],
            'uri_alias'  => [
                'required',
                'min:4',
                'max:32',
                new UriSlug()
            ],
            'year'       => [
                'required',
                'numeric',
                'min:'.min($groupYear, $currentYear - 4),
                'max:'.$currentYear
            ],
            'created_by' => [
                'sometimes',
                'nullable',
                'integer',
                'min:1',
                'exists:'.Administrator::class.',id'
            ]
        ];
    }
}
