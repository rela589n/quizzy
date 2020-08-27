<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class ChangePasswordController extends Controller
{
    protected string $guardName;
    protected string $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @param string $guardName
     */
    public function __construct($guardName)
    {
        $this->guardName = $guardName;
        $this->middleware('auth:' . $guardName);

        $routeName = $guardName . '.dashboard';
        $this->redirectTo = Route::has($routeName) ? route($routeName) : '/';
    }

    protected function newPassword(ChangePasswordRequest $request)
    {
        return $request->input('new_password');
    }

    protected function changePassword(ChangePasswordRequest $request): void
    {
        $authUser = $request->getAuthUser();

        $authUser->password = \Hash::make($this->newPassword($request));
        $authUser->password_changed = true;

        $authUser->save();
    }

    public function showInitialPasswordChangeForm(Request $request): View
    {
        return view(sprintf('pages.%s.initial-password-change', $this->guardName));
    }
}
