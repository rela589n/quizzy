<?php

namespace App\Http\Requests\Subjects;

use Illuminate\Foundation\Http\FormRequest;

class SubjectGetRequest extends SubjectRequest
{
    public function authorize()
    {
        return true;
    }
}
