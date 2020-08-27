<?php


namespace App\Http\Requests\Users\Students;


use App\Models\Administrator;
use App\Models\User;
use App\Rules\Containers\Users\StudentRulesContainer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateStudentRequest extends FormRequest
{
    private ?User $student = null;

    public function student(): User
    {
        return singleVar(
            $this->student,
            function () {
                return User::findOrFail($this->route('studentId'));
            }
        );
    }

    public function authorize(Administrator $user): bool
    {
        if (!$user->can('update', $this->student())) {
            return false;
        }

        if (!is_null($this->input('student_group_id'))) {
            return $user->can('edit-group-of-student');
        }

        return true;
    }

    public function rules(StudentRulesContainer $container): array
    {
        $rules = $container->getRules();

        $rules[$container->usernameAttr()][] = Rule::unique('users')
            ->ignoreModel($this->student());

        $rules[$container->passwordAttr()][] = 'nullable';

        $rules['student_group_id'] = [
            'sometimes',
            'numeric',
            'exists:student_groups,id'
        ];

        return $rules;
    }
}
