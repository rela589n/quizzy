<?php

namespace App\Http\Requests\Tests\Transfers;

use App\Http\Requests\RequestUrlManager;
use App\Models\Administrator;
use Illuminate\Foundation\Http\FormRequest;

class ImportTestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Administrator $user
     * @param RequestUrlManager $urlManager
     * @return bool
     */
    public function authorize(Administrator $user, RequestUrlManager $urlManager)
    {
        return $user->can('update', $urlManager->getCurrentTest());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'selected-file' => [
                'required',
                'file',
                'max:2048',
                'mimes:docx,txt'
            ]
        ];
    }
}
