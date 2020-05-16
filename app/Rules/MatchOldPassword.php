<?php

namespace App\Rules;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Validation\Rule;

final class MatchOldPassword implements Rule
{
    protected $user;

    /**
     * Create a new rule instance.
     *
     * @param Authenticatable $user
     */
    public function __construct($user)
    {
        $this->user = $user;
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
        return \Hash::check($value, $this->user->getAuthPassword());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('auth.custom.password_doesnt_match');
    }
}
