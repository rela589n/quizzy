<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestUrlManager;

abstract class AdminController extends Controller
{
    /** @var RequestUrlManager */
    protected $urlManager;

    public function __construct(RequestUrlManager $urlManager)
    {
        $this->urlManager = $urlManager;
        $this->middleware('auth:admin');
        $this->middleware('password.change:admin');
    }
}
