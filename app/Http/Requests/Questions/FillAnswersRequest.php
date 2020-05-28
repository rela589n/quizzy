<?php

namespace App\Http\Requests\Questions;

use App\Http\Requests\RequestUrlManager;
use App\Lib\ValidationGenerator;
use App\Models\Administrator;
use App\Rules\AtLeastOneSelected;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

final class FillAnswersRequest extends FormRequest
{
    /** @var ValidationGenerator */
    protected $validationGenerator;

    /** @var array */
    protected $validatedData;

    protected function &validatedData()
    {
        return singleVar($this->validatedData, function () {
            $this->validatedData = $this->validated();
        });
    }

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
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return $this->validationGenerator->buildManyAttributes([
            'q.new.*.v.*.text|q.modified.*.v.*.text' => trans('validation.attributes.option_text'),
            'q.new.*.name|q.modified.*.name'         => trans('validation.attributes.questions'),
            'q.new.*.v|q.modified.*.v'               => trans('validation.attributes.answer_options'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param ValidationGenerator $generator
     * @return array
     */
    public function rules(ValidationGenerator $generator)
    {
        $this->validationGenerator = $generator;

        return $this->validationGenerator->buildManyRules([
            'q|q.new|q.modified'                             => 'array',
            'q.new.*.name|q.modified.*.name'                 => 'required|min:3|max:255',
            'q.new.*.v|q.modified.*.v'                       => [
                'required',
                'array',
                'min:2',
                new AtLeastOneSelected('is_right')
            ],
            'q.new.*.v.*|q.modified.*.v.*'                   => [
                'required',
                'array',
            ],
            'q.new.*.v.*.is_right|q.modified.*.v.*.is_right' => [
                'sometimes',
                Rule::in('0', '1')
            ],
            'q.new.*.v.*.text|q.modified.*.v.*.text'         => 'required|min:1|max:255',
            'q.deleted|v.deleted'                            => 'array|min:1',
        ]);
    }

    public function answerOptionsToDelete(): array
    {
        return $this->validatedData()['v']['deleted'] ?? [];
    }

    public function questionsToDelete(): array
    {
        return $this->validatedData()['q']['deleted'] ?? [];
    }

    public function questionsToCreate()
    {
        return $this->transformQuestions($this->validatedData()['q']['new'] ?? []);
    }

    public function questionsToUpdate()
    {
        return $this->transformQuestions($this->validatedData()['q']['modified'] ?? []);
    }

    protected function transformQuestions($rawQuestions)
    {
        $questions = [];

        foreach ($rawQuestions as $questionId => $question) {

            $answerOptions = [];

            foreach ($question['v'] as $optionId => $option) {

                $option['id'] = $optionId;
                $answerOptions[] = [
                    'id'       => $optionId,
                    'text'     => $option['text'],
                    'is_right' => $option['is_right'] ?? '0'
                ];
            }

            $questions[] = [
                'id'            => $questionId,
                'question'      => $question['name'],
                'answerOptions' => $answerOptions
            ];
        }

        return $questions;
    }

    protected function failedValidation(Validator $validator)
    {
        Session::push('message', trans('validation.custom.some-questions-have-errors'));

        parent::failedValidation($validator);
    }
}
