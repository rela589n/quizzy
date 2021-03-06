<?php

namespace App\Nova;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;

abstract class Resource extends NovaResource
{
    protected static bool $redirectToParentOnCreate = false;
    protected static bool $redirectToParentOnUpdate = false;

    protected static array $defaultOrderings = [];

    /**
     * Build an "index" query for the given resource.
     *
     * @param  NovaRequest  $request
     * @param  Builder  $query
     * @return Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a Scout search query for the given resource.
     *
     * @param  NovaRequest  $request
     * @param  \Laravel\Scout\Builder  $query
     * @return \Laravel\Scout\Builder
     */
    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a "detail" query for the given resource.
     *
     * @param  NovaRequest  $request
     * @param  Builder  $query
     * @return Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param  NovaRequest  $request
     * @param  Builder  $query
     * @return Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query);
    }

    public static function redirectAfterCreate(NovaRequest $request, $resource): string
    {
        if (static::$redirectToParentOnCreate && $request->viaRelationship()) {
            return "/resources/{$request->get('viaResource')}/{$request->get('viaResourceId')}";
        }

        return parent::redirectAfterCreate($request, $resource);
    }

    public static function redirectAfterUpdate(NovaRequest $request, $resource): string
    {
        if (static::$redirectToParentOnUpdate && $request->viaRelationship()) {
            return "/resources/{$request->get('viaResource')}/{$request->get('viaResourceId')}";
        }

        return parent::redirectAfterUpdate($request, $resource);
    }

    public static function createButtonLabel()
    {
        return __('Створити :resource', ['resource' => mb_lcfirst(static::singularLabel())]);
    }

    public static function updateButtonLabel()
    {
        return __('Редагувати :resource', ['resource' => mb_lcfirst(static::singularLabel())]);
    }

    /**
     * @param  Builder|Relation|mixed  $query
     * @param  array  $orderings
     * @return Builder|Relation|mixed
     */
    protected static function applyOrderings($query, array $orderings)
    {
        if (empty($orderings) && !empty(static::$defaultOrderings)) {
            $orderings = static::$defaultOrderings;
        }

        return parent::applyOrderings($query, $orderings);
    }
}
