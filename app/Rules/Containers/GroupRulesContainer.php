<?php


namespace App\Rules\Containers;


use App\Http\Requests\RequestUrlManager;
use App\Models\Administrator;
use App\Rules\UriSlug;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class GroupRulesContainer
{
    /** @var RequestUrlManager */
    private $urlManager;

    public function __construct(RequestUrlManager $urlManager)
    {
        $this->urlManager = $urlManager;
    }

    public function getRules() : array
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
                'min:' . min($groupYear, $currentYear - 4),
                'max:' . $currentYear
            ],
            'created_by' => [
                'sometimes',
                'nullable',
                'integer',
                'min:1',
                'exists:' . Administrator::class . ',id'
            ]
        ];
    }
}
