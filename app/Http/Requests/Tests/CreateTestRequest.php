<?php

namespace App\Http\Requests\Tests;


class CreateTestRequest extends TestRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [ // something wrong is going with substitution of attribute names in arrays
            'include.*.count' => '"Кількість"'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'include.*.count.required_with' => 'Якщо ви вибрали цей предмет, то обов\'язково вкажіть кількість питань з нього.'
        ];
    }

    public function rules()
    {
        $rules = $this->baseRules;
        $rules['uri_alias'][] = 'unique:tests';
        return $rules;
    }
}
