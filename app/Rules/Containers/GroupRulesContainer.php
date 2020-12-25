<?php


namespace App\Rules\Containers;


use App\Http\Requests\RequestUrlManager;
use App\Models\Administrator;
use App\Models\StudentGroup;
use App\Rules\UriSlug;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rules\Unique;

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

        $rules['year'][] = 'min:'.(date('Y') - 4);

        return $rules;
    }

    public function updateRules(StudentGroup $group): array
    {
        $rules = $this->commonRules();

        $rules['year'][] = 'min:'.min(date('Y') - 4, $group->year);
        $rules['uri_alias']['uniqueness']->ignoreModel($group);

        return $rules;
    }

    public function commonRules(): array
    {
        return [
            'uri_alias'  => [
                'required',
                'min:4',
                'max:32',
                new UriSlug(),
                'uniqueness' => new Unique('student_groups'),
            ],
            'name'       => [
                'required',
                'min:4',
                'max:32',
                'unique:'.StudentGroup::class,
            ],
            'created_by' => [
                'sometimes',
                'nullable',
                'integer',
                'min:1',
                "exists:".Administrator::class.",id",
            ],
            'year'       => [
                'required',
                'numeric',
                'max:'.date('Y'),
            ],
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
