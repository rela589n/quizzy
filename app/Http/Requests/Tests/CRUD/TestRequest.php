<?php


namespace App\Http\Requests\Tests\CRUD;


use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
{
    public function attributes()
    {
        return ['custom' => trans('validation.attributes.custom')];
    }
}
