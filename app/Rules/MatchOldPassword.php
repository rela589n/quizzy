<?php

namespace App\Rules;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Validation\Rule;

final class MatchOldPassword implements Rule
{
    protected Authenticatable $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function passes($attribute, $value): bool
    {
        return \Hash::check($value, $this->user->getAuthPassword());
    }

    public function message(): string
    {
        return trans('auth.custom.password_doesnt_match');
    }
}
