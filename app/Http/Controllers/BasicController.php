<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestUrlManager;

abstract class BasicController extends Controller
{
    protected $urlManager;

    /**
     *
     * Basic controller for Admin and Client routes (except login forms).
     * @param RequestUrlManager $urlManager
     */
    public function __construct(RequestUrlManager $urlManager)
    {
        $this->urlManager = $urlManager;
    }
}
