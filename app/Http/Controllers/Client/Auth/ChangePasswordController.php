<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Requests\Auth\StudentChangePasswordRequest;
use Illuminate\Http\RedirectResponse;

class ChangePasswordController extends \App\Http\Controllers\Auth\ChangePasswordController
{
    public function __construct()
    {
        parent::__construct('client');
    }

    public function initialChangePassword(StudentChangePasswordRequest $request): RedirectResponse
    {
        $this->changePassword($request);
        return redirect($this->redirectTo);
    }
}
