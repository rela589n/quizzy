<?php

namespace App\Http\Requests\Groups;

use App\Http\Requests\UrlManageable;
use App\Http\Requests\UrlManageableRequests;
use App\Models\Administrator;
use App\Rules\UriSlug;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;

abstract class GroupRequest extends FormRequest implements UrlManageable
{
    use UrlManageableRequests;

    public abstract function authorize(Administrator $administrator);

    /**
     * @return \App\Models\StudentGroup|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function studentGroup()
    {
        return $this->urlManager->getCurrentGroup();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules()
    {
        $currentYear = date('Y');

        try {
            $currentGroup = $this->studentGroup();
            $groupYear = $currentGroup->year;
        } catch (ModelNotFoundException $e) {
            $groupYear = $currentYear;
        }

        return [
            'name'      => [
                'required',
                'min:4',
                'max:32'
            ],
            'uri_alias' => [
                'required',
                'min:4',
                'max:32',
                new UriSlug()
            ],
            'year'      => [
                'required',
                'numeric',
                'min:' . min($groupYear, $currentYear - 4),
                'max:' . $currentYear
            ]
        ];
    }
}
