<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

final class UriSlug implements Rule
{
    public function passes($attribute, $value): bool
    {
        return preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value);
    }

    public function message(): string
    {
        return trans('validation.custom.uri_slug');
    }
}
