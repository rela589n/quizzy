<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Administrator;

use App\Models\Administrator;
use Laravel\Nova\Http\Requests\NovaRequest;
use OptimistDigital\MultiselectField\Multiselect;
use Spatie\Permission\Models\Role;

final class RoleField
{
    private static $rolesCache = null;

    public static function make(Administrator $user)
    {
        $roles = self::$rolesCache
            ?? (self::$rolesCache = $user->availableRolesQuery()->get(['name', 'public_name']));

        return Multiselect::make('Роль', 'role')
            ->options(
                $roles->pluck('name')
                    ->combine($roles->pluck('public_name'))
            )->resolveUsing(
                static fn($value, Administrator $resource) => $resource->roles->pluck('name')
            )->fillUsing(
                static function (NovaRequest $request, Administrator $model, $attribute, $requestAttribute) {
                    $model->syncRoles($request->get($requestAttribute));
                }
            );
    }
}
