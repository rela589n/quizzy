<?php

namespace App\Providers;

use App\Lib\Transformers\QuestionsTransformer;
use App\Lib\ValidationGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class LibServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(
            ValidationGenerator::class,
            static function () {
                return new ValidationGenerator(resolve(Request::class));
            }
        );

        $this->app->singleton(QuestionsTransformer::class);
    }
}
