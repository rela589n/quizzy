<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

final class ExactlyOneSelected implements Rule
{
    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function passes($attribute, $value): bool
    {
        $countSelected = 0;

        foreach ($value as $item) {
            if (isset($item[$this->key])
                && filter_var($item[$this->key], FILTER_VALIDATE_BOOLEAN)) {
                ++$countSelected;
            }
        }

        return 1 === $countSelected;
    }

    public function message()
    {
        return trans('validation.custom.exactly_one_checked');
    }
}
