<?php

namespace App\Http\Requests\Tests;


use App\Http\Requests\RequestUrlManager;
use Illuminate\Foundation\Http\FormRequest;

class FinishTestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param RequestUrlManager $urlManager
     * @return bool
     */
    public function authorize(RequestUrlManager $urlManager)
    {
        return $this->user('client')->can('pass-test', $urlManager->getCurrentTest());
    }

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
