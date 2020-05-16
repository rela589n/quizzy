<?php


namespace App\Rules\Containers;


use App\Rules\UriSlug;

final class DepartmentRulesContainer
{
    public function getRules()
    {
        return [
            'name' => [
                'required',
                'min:4',
                'max:128'
            ],
            'uri_alias' => [
                'required',
                'min:4',
                'max:64',
                new UriSlug()
            ],
        ];
    }
}
