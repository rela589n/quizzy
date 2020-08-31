<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
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
    public function boot(): void
    {
        if (!EloquentCollection::hasMacro('paginate')) {
            EloquentCollection::macro(
                'paginate',
                function ($perPage = 15, $page = null, $options = []) {
                    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                    return (new LengthAwarePaginator(
                        $this->forPage($page, $perPage),
                        $this->count(),
                        $perPage,
                        $page,
                        $options
                    )
                    )->withPath('');
                }
            );
        }

        if (!EloquentCollection::hasMacro('setRelation')) {
            EloquentCollection::macro(
                'setRelation',
                function ($relation, $value) {
                    $this->map(
                        static function (Model $model) use ($relation, $value) {
                            $model->setRelation($relation, $value);
                        }
                    );

                    return $this;
                }
            );
        }
    }
}
