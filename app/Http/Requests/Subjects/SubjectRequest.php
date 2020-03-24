<?php

namespace App\Http\Requests\Subjects;

use Illuminate\Foundation\Http\FormRequest;

abstract class SubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public abstract function authorize();

    public function attributes()
    {
        return [
            'course' => 'Курс'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:128'
            ],
            'uri_alias' => [
                'required',
                'min:3',
                'max:48',
            ],
            'course' => [
                'required',
                'numeric',
                'min:1',
                'max:4'
            ]
        ];
    }
}
