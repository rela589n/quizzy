<?php

declare(strict_types=1);


namespace App\Http\Requests\Tests\Pass;

use App\Http\Requests\RequestUrlManager;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

final class AddQuestionToResponseRequest extends FormRequest
{
    public function authorize(User $user, RequestUrlManager $urlManager): bool
    {
        return $user->can('pass-test', $urlManager->getCurrentTest());
    }

    public function rules(): array
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
