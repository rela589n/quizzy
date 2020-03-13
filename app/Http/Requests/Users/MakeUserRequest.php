<?php

namespace App\Http\Requests\Users;

use App\Lib\ValidationGenerator;
use Illuminate\Foundation\Http\FormRequest;

abstract class MakeUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // todo handle permissions
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param ValidationGenerator $generator
     * @return array
     */
    public function rules(ValidationGenerator $generator)
    {
        return $generator->buildManyRules([
            'name|surname|patronymic' => 'required|min:2|max:255',
            $this->username() => 'required|string|min:5|max:255',
            'password' => 'string'
        ]);
    }

    protected function username()
    {
        return 'email';
    }
}
