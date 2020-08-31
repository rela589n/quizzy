<?php


namespace App\Http\Requests\Users\Teachers;


use App\Rules\Containers\Users\TeacherRulesContainer;
use Illuminate\Foundation\Http\FormRequest;

abstract class TeacherRequest extends FormRequest
{
    public function attributes(): array
    {
        return $this->getRulesContainer()->getAttributes();
    }

    abstract protected function getRulesContainer(): TeacherRulesContainer;
}
