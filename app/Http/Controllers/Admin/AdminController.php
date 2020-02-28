<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BasicController;
use App\Http\Requests\RequestUrlManager;

abstract class AdminController extends BasicController
{
    public function __construct(RequestUrlManager $urlManager)
    {
        parent::__construct($urlManager);
        $this->middleware('auth:admin');
        $this->middleware('password.change:admin');
    }
}
