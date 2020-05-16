<?php

namespace App\Http\Requests\Auth;

use App\Lib\ValidationGenerator;
use App\Models\BaseUser;
use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

abstract class ChangePasswordRequest extends FormRequest
{
    /** @var BaseUser */
    protected $authUser;

    /**
     * @param BaseUser $authUser
     */
    public function setAuthUser(BaseUser $authUser): void
    {
        $this->authUser = $authUser;
    }

    /**
     * @return BaseUser
     */
    public function getAuthUser(): BaseUser
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
        log_r($this->authUser->toArray());
        log_r($this->all());

        return $generator->buildManyRules([
            'new_password|new_password_confirmation' => 'required|string|min:6',

            'password'     => [
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
