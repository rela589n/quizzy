<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Requests\Auth\StudentChangePasswordRequest;

class ChangePasswordController extends \App\Http\Controllers\Auth\ChangePasswordController
{
    public function __construct()
    {
        parent::__construct('client');
    }

    public function initialChangePassword(StudentChangePasswordRequest $request)
    {
        $this->changePassword($request);
        return redirect($this->redirectTo);
    }
}
