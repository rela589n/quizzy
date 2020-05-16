<?php

namespace App\Http\Requests\Tests;


use App\Http\Requests\RequestUrlManager;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

final class FinishTestRequest extends FormRequest
{
    /**
     * Determine if the student is authorized to pass current test.
     *
     * @param User $user
     * @param RequestUrlManager $urlManager
     * @return bool
     */
    public function authorize(User $user, RequestUrlManager $urlManager)
    {
        return $user->can('pass-test', $urlManager->getCurrentTest());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ans'     => 'array',
            'ans.*'   => 'array',
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

            'asked'   => 'array|required',
            'asked.*' => 'array',

            'asked.*.question_id' => [
                'required',
                'numeric'
            ],
        ];
    }
}
