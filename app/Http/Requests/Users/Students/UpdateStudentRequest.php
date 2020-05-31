<?php


namespace App\Http\Requests\Users\Students;


use App\Models\Administrator;
use App\Models\User;
use App\Rules\Containers\Users\StudentRulesContainer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateStudentRequest extends FormRequest
{
    private $student;

    public function student()
    {
        return singleVar($this->student, function () {
            return User::findOrFail($this->route('studentId'));
        });
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Administrator $user
     * @return bool
     */
    public function authorize(Administrator $user)
    {
        if (!$user->can('update', $this->student()))
            return false;

        if (!is_null($this->input('student_group_id')))
            return $user->can('edit-group-of-student');

        return true;
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
