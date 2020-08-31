<?php


namespace App\Http\Requests\Users\Students;

use App\Models\Administrator;
use App\Rules\Containers\Users\StudentRulesContainer;
use Illuminate\Foundation\Http\FormRequest;

final class CreateStudentRequest extends FormRequest
{
    public function authorize(Administrator $user): bool
    {
        return $user->can('create-students');
    }

    public function rules(StudentRulesContainer $container): array
    {
        $rules = $container->getRules();
        $rules[$container->usernameAttr()][] = 'unique:users';

        return $rules;
    }
}
