<?php


namespace App\Rules\Containers;


use App\Rules\UriSlug;

class DepartmentRulesContainer implements RulesContainerInterface
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
