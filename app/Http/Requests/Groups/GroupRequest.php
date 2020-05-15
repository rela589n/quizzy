<?php

namespace App\Http\Requests\Groups;

use Illuminate\Foundation\Http\FormRequest;

abstract class GroupRequest extends FormRequest
{
    public function attributes()
    {
        return [
            'created_by' => '"староста"'
        ];
    }
}
