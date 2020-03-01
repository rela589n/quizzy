<?php

namespace App\Http\Requests\Groups;

use App\Http\Requests\UrlManageable;
use App\Http\Requests\UrlManageableRequests;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;

abstract class GroupRequest  extends FormRequest implements UrlManageable
{
    use UrlManageableRequests;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules()
    {
        $currentYear = date('Y');
        try {
            $currentGroup = $this->urlManager->getCurrentGroup();
            $groupYear = $currentGroup->year;
        } catch (ModelNotFoundException $e) {
            $groupYear = $currentYear;
        }

        return [
            'name' => [
                'required',
                'min:4',
                'max:32'
            ],
            'uri_alias' => [
                'required',
                'min:4',
                'max:32',
            ],
            'year' => [
                'required',
                'numeric',
                'min:' . min($groupYear, $currentYear - 4),
                'max:' . $currentYear
            ]
        ];
    }
}
