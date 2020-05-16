<?php


namespace App\Rules\Containers;


use App\Rules\UriSlug;

final class SubjectRulesContainer
{
    public function getRules()
    {
        return [
            'name'          => [
                'required',
                'min:3',
                'max:128'
            ],
            'uri_alias'     => [
                'required',
                'min:3',
                'max:48',
                new UriSlug()
            ],
            'courses'       => [
                'required',
                'array',
                'min:1',
            ],
            'courses.*'     => [
                'required',
                'numeric',
                'min:1',
                'exists:courses,id'
            ],
            'departments'   => [
                'required',
                'array',
                'min:1',
            ],
            'departments.*' => [
                'required',
                'numeric',
                'min:1',
                'exists:departments,id'
            ],
        ];
    }
}
