<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BasicController;
use App\Http\Requests\RequestUrlManager;

abstract class ClientController extends BasicController
{
    public function __construct(RequestUrlManager $urlManager)
    {
        parent::__construct($urlManager);
        $this->middleware('auth');
    }
}
