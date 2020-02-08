<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AtLeastOneSelected implements Rule
{
    private $key;

    /**
     * Create a new rule instance.
     *
     * @param string|int $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($value as $item) {
            if (isset($item[$this->key])) {
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
    public function message()
    {
        return trans('validation.custom.at_least_one_checked');
    }
}
