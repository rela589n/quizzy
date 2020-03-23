<?php

namespace App\Http\Requests\Auth;

use App\Lib\ValidationGenerator;
use App\Rules\MatchOldPassword;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Http\FormRequest;

abstract class ChangePasswordRequest extends FormRequest
{
    protected $authUser;

    /**
     * @param Authenticatable $authUser
     */
    public function setAuthUser($authUser): void
    {
        $this->authUser = $authUser;
    }

    /**
     * @return mixed
     */
    public function getAuthUser()
    {
        return $this->authUser;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param ValidationGenerator $generator
     * @return array
     */
    public function rules(ValidationGenerator $generator)
    {
        return $generator->buildManyRules([
            'new_password|new_password_confirmation' => 'required|string|min:6',
            'password' => [
                'required',
                'string',
                new MatchOldPassword($this->authUser)
            ],
            'new_password' => [
                'confirmed',
                'different:password'
            ],
        ]);
    }
}
