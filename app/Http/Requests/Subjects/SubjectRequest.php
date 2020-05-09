<?php

namespace App\Http\Requests\Subjects;

use App\Models\Administrator;
use App\Rules\UriSlug;
use Illuminate\Foundation\Http\FormRequest;

abstract class SubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Administrator $user
     * @return bool
     */
    public abstract function authorize(Administrator $user);

    public function attributes()
    {
        return [
            'courses.*'     => '"курс"',
            'departments.*' => '"відділення"',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules()
    {
        return [
            'name'          => [
                'required',
                'min:3',
                'max:128'
            ],
            'uri_alias'     => [
                'required',
                'min:3',
                'max:48',
                new UriSlug()
            ],
            'courses'       => [
                'required',
                'array',
                'min:1',
            ],
            'courses.*'     => [
                'required',
                'numeric',
                'min:1',
                'exists:courses,id'
            ],
            'departments'   => [
                'required',
                'array',
                'min:1',
            ],
            'departments.*' => [
                'required',
                'numeric',
                'min:1',
                'exists:departments,id'
            ],
        ];
    }
}
