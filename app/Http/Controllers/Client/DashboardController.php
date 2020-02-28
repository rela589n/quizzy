<?php

namespace App\Http\Controllers\Client;

class DashboardController extends ClientController
{
    public function showDashboardPage()
    {
        return view('pages.client.dashboard');
    }
}
