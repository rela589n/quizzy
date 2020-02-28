<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Requests\Auth\AdminChangePasswordRequest;

class ChangePasswordController extends \App\Http\Controllers\Auth\ChangePasswordController
{
    public function __construct()
    {
        parent::__construct('admin');
    }

    public function initialChangePassword(AdminChangePasswordRequest $request)
    {
        $this->changePassword($request);
        return redirect($this->redirectTo);
    }
}
