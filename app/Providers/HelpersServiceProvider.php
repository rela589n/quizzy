<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Include helpers.
     *
     * @return void
     */
    public function boot(): void
    {
        require app_path('Includes/debug-helpers.php');
        require app_path('Includes/helpers.php');
    }
}
