<?php

declare(strict_types=1);


namespace App\Rules\Containers\Department;

use App\Rules\Containers\RulesContainer;
use App\Rules\UriSlug;

final class DepartmentUriSlugRules extends RulesContainer
{
    protected function rules(): array
    {
        return [
            'required',
            'min:4',
            'max:64',
            new UriSlug()
        ];
    }

    public static function forCreate(): self
    {
        $rules = new self();
        $rules->merge(['unique:departments,uri_alias']);

        return $rules;
    }

    public static function forUpdate(): self
    {
        $rules = new self();
        $rules->merge(['unique:departments,uri_alias,{{resourceId}}']);

        return $rules;
    }
}
