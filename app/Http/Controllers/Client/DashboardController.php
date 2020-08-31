<?php

namespace App\Http\Controllers\Client;

use Illuminate\View\View;

class DashboardController extends ClientController
{
    public function showDashboardPage(): View
    {
        return view('pages.client.dashboard');
    }
}
