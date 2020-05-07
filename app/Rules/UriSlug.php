<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UriSlug implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'URI-псевдонім може містити лише латинські літери, цифри та дефіси!';
    }
}
