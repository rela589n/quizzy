<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectsRequest extends FormRequest
{

    public function messages()
    {
        return [
            //
        ];
    }

    public function attributes()
    {
        return [
            'uri_alias' => 'uri-псевдонім',
            'course' => 'Курс'
        ];
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:128',
            'uri_alias' => [
                'required',
                'min:3',
                'max:48',
                'unique:test_subjects'
            ],
            'course' => 'required|numeric|min:1|max:4'
        ];
    }
}
