<?php

namespace App\Http\Controllers\Client\Auth;

class LoginController extends \App\Http\Controllers\Auth\LoginController
{
    public function __construct()
    {
        parent::__construct('client');
    }
}
