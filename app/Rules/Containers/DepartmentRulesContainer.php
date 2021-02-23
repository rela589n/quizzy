<?php


namespace App\Rules\Containers;


use App\Rules\Containers\Department\DepartmentNameRules;
use App\Rules\Containers\Department\DepartmentUriSlugRules;

final class DepartmentRulesContainer
{
    public function getRules(): array
    {
        return [
            'name'      => new DepartmentNameRules(),
            'uri_alias' => new DepartmentUriSlugRules(),
        ];
    }
}
