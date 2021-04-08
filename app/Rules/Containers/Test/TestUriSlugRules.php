<?php

declare(strict_types=1);


namespace App\Rules\Containers\Test;

use App\Rules\Containers\RulesContainer;
use App\Rules\UriSlug;

final class TestUriSlugRules extends RulesContainer
{
    protected function rules(): array
    {
        return [
            'required',
            'min:3',
            'max:48',
            new UriSlug()
        ];
    }

    public static function forCreate(): self
    {
        $rules = new self();
        $rules->merge(['unique:tests,uri_alias']);

        return $rules;
    }

    public static function forUpdate(): self
    {
        $rules = new self();
        $rules->merge(['unique:tests,uri_alias,{{resourceId}}']);

        return $rules;
    }
}
