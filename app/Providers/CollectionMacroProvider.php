<?php

namespace App\Providers;

use App\Lib\Traits\LoadTrashed;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class CollectionMacroProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (!EloquentCollection::hasMacro('paginate')) {
            EloquentCollection::macro('paginate', function ($perPage = 15, $page = null, $options = []) {
                $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                return (new LengthAwarePaginator(
                    $this->forPage($page, $perPage),
                    $this->count(),
                    $perPage,
                    $page,
                    $options)
                )->withPath('');
            });
        }
    }
}
