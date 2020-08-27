<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;

class DashboardController extends AdminController
{
    public function showDashboardPage(): View
    {
        return view('pages.admin.dashboard');
    }
}
