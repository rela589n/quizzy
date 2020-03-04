<?php

namespace App\Http\Requests\Tests;

use Illuminate\Foundation\Http\FormRequest;

class FinishTestRequest extends PassTestRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ans' => 'array',
            'ans.*' => 'array',
            'ans.*.*' => 'array',
            'ans.*.*.answer_option_id' => [
                'required',
                'numeric'
            ],
            'ans.*.*.is_chosen' => [
                'sometimes',
                'required',
                'numeric'
            ],
            'asked' => 'array',
            'asked.*' => 'array',
            'asked.*.question_id' => [
                'required',
                'numeric'
            ],
        ];
    }
}
