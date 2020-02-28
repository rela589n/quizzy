<?php

namespace App\Http\Controllers\Admin;

class DashboardController extends AdminController
{
    public function showDashboardPage()
    {
        return view('pages.admin.dashboard');
    }
}
