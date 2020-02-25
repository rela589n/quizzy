<?php

namespace App\Http\Controllers\Admin;

class DashboardController extends AdminController
{
    public function showHelloPage()
    {
        return view('pages.admin.dashboard');
    }
}
