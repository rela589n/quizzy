<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Requests\Auth\AdminChangePasswordRequest;
use Illuminate\Http\RedirectResponse;

class ChangePasswordController extends \App\Http\Controllers\Auth\ChangePasswordController
{
    public function __construct()
    {
        parent::__construct('admin');
    }

    public function initialChangePassword(AdminChangePasswordRequest $request): RedirectResponse
    {
        $this->changePassword($request);
        return redirect($this->redirectTo);
    }
}
