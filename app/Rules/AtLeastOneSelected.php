<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

final class AtLeastOneSelected implements Rule
{
    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function passes($attribute, $value): bool
    {
        foreach ($value as $item) {
            if (isset($item[$this->key])
                && filter_var($item[$this->key],FILTER_VALIDATE_BOOLEAN))
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans('validation.custom.at_least_one_checked');
    }
}
