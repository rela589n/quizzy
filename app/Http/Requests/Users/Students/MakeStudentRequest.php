<?php

namespace App\Http\Requests\Users\Students;


use App\Http\Requests\Users\MakeUserRequest;
use App\Lib\ValidationGenerator;

abstract class MakeStudentRequest extends MakeUserRequest
{
    protected $validateGroup = false;

    /**
     * @param bool $validateGroup
     */
    public function setValidateGroup(bool $validateGroup): void
    {
        $this->validateGroup = $validateGroup;
    }

    public function rules(ValidationGenerator $generator)
    {
        $rules = parent::rules($generator);

        if ($this->validateGroup) {
            $rules['student_group_id'] = [
                'required',
                'numeric'
            ];
        }

        return $rules;
    }
}
