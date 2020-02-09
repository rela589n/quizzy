<?php

namespace App\Http\Requests\Questions;

use App\Lib\ValidationGenerator;
use App\Rules\AtLeastOneSelected;
use Illuminate\Foundation\Http\FormRequest;

class FillAnswersRequest extends FormRequest
{
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
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return $this->validationGenerator->buildMany([
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
        return $this->validationGenerator->buildMany([
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
            'q.deleted' => 'array|min:1'
        ]);
    }
}
