<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestUrlManager;

abstract class ClientController extends Controller
{
    /** @var RequestUrlManager */
    protected $urlManager;

    public function __construct(RequestUrlManager $urlManager)
    {
        $this->urlManager = $urlManager;
        $this->middleware('auth:client');
        $this->middleware('password.change:client');
    }
}
