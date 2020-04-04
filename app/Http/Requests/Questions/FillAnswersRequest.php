<?php

namespace App\Http\Requests\Questions;

use App\Http\Requests\RequestUrlManager;
use App\Lib\ValidationGenerator;
use App\Models\Administrator;
use App\Rules\AtLeastOneSelected;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;

class FillAnswersRequest extends FormRequest
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
     * @var ValidationGenerator
     */
    protected $validationGenerator;

    /**
     * @param ValidationGenerator $validationGenerator
     */
    public function setValidationGenerator($validationGenerator): void
    {
        $this->validationGenerator = $validationGenerator;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return $this->validationGenerator->buildManyAttributes([
            'q.new.*.v.*.text|q.modified.*.v.*.text' => '',
            'q.new.*.name|q.modified.*.name' => '"Питання"',
            'q.new.*.v|q.modified.*.v' => '"Варіанти відповідей"'
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->validationGenerator->buildManyRules([
            'q|q.new|q.modified' => 'array',
            'q.new.*.name|q.modified.*.name' => 'required|min:3|max:255',
            'q.new.*.v|q.modified.*.v' => [
                'required',
                'array',
                'min:2',
                new AtLeastOneSelected('is_right')
            ],
            'q.new.*.v.*|q.modified.*.v.*' => [
                'required',
                'array',
            ],
            'q.new.*.v.*.text|q.modified.*.v.*.text' => 'required|min:2|max:128',
            'q.deleted|v.deleted' => 'array|min:1',
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        Session::push('message', 'Деякі питання містять помилки!');

        parent::failedValidation($validator);
    }
}
