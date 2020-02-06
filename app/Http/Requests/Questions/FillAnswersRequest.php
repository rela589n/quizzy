<?php

namespace App\Http\Requests\Questions;

use Illuminate\Foundation\Http\FormRequest;

class FillAnswersRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        dd($this->all());

        $nameRules = [
            'required',
            'min:3',
            'max:255',
        ];

        $variantTextRules = [
            'required',
            'min:1',
            'max:128',
        ];

        $atLeastOneRight = [
//            'required_without:q.new.*.v.*.is_right',
//            'array',
//            'min:1'
        ];

        return [
            'q' => [
                'array',
            ],
            'q.new.*.name' => $nameRules,
            'q.modified.*.name' => $nameRules,

            'q.new.*.v.*.text' => $variantTextRules,
            'q.modified.*.v.*.text' => $variantTextRules,

            'q.new' => [
                'array',
            ],
            'q.modified' => [
                'array',
            ],
            'q.new.*.v.*.is_right' => $atLeastOneRight,
//            'q.modified.*.v.*.is_right' => $atLeastOneRight,
        ];
    }
}
