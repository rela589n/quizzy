<?php


namespace App\Http\Requests\Users\Students;

use App\Models\Administrator;
use App\Rules\Containers\Users\StudentRulesContainer;
use Illuminate\Foundation\Http\FormRequest;

final class CreateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Administrator $user
     * @return bool
     */
    public function authorize(Administrator $user)
    {
        return $user->can('create-students');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param StudentRulesContainer $container
     * @return array
     */
    public function rules(StudentRulesContainer $container): array
    {
        $rules = $container->getRules();
        $rules[$container->usernameAttr()][] = 'unique:users';

        return $rules;
    }
}
