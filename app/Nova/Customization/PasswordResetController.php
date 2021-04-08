<?php

declare(strict_types=1);


namespace App\Nova\Customization;

use Laravel\Nova\Nova;
use Mastani\NovaPasswordReset\Http\Requests\PasswordResetRequest;

final class PasswordResetController extends \Mastani\NovaPasswordReset\Http\Controllers\PasswordResetController
{
    public function reset(PasswordResetRequest $request)
    {
        $response = parent::reset($request);

        $user = $request->user();
        $user->password_changed = true;
        $user->save();

        return $response;
    }
}
