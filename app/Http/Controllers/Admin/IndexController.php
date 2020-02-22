<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestUrlManager;
use Illuminate\Http\Request;

abstract class IndexController extends Controller
{
    protected $urlManager;

    /**
     * IndexController constructor.
     * @param RequestUrlManager $urlManager
     */
    public function __construct(RequestUrlManager $urlManager)
    {
        $this->urlManager = $urlManager;
//        $this->middleware('auth');
    }
}
