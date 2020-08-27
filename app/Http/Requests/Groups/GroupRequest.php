<?php

namespace App\Http\Requests\Groups;

use Illuminate\Foundation\Http\FormRequest;

abstract class GroupRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'created_by' => trans('validation.attributes.class_monitor')
        ];
    }
}
