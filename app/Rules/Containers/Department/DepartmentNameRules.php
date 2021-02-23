<?php

declare(strict_types=1);


namespace App\Rules\Containers\Department;

use App\Rules\Containers\RulesContainer;

final class DepartmentNameRules extends RulesContainer
{
    protected function rules(): array
    {
        return [
            'required',
            'min:4',
            'max:128'
        ];
    }

    public static function forCreate(): self
    {
        $rules = new self();
        $rules->merge(['unique:departments,name']);

        return $rules;
    }

    public static function forUpdate(): self
    {
        $rules = new self();
        $rules->merge(['unique:departments,name,{{resourceId}}']);

        return $rules;
    }
}
