<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class SyncTeacherAdministratorsPermission extends Migration
{
    public function up()
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        /** @var \Spatie\Permission\Models\Role $role */
        $role = \Spatie\Permission\Models\Role::query()->where('name', 'teacher')->firstOrFail();

        $role->givePermissionTo('create-administrators');
        $role->givePermissionTo('view-administrators');
        $role->givePermissionTo('update-administrators');
        $role->givePermissionTo('delete-administrators');
    }

    public function down()
    {
        /** @var \Spatie\Permission\Models\Role $role */
        $role = \Spatie\Permission\Models\Role::query()->where('name', 'teacher')->firstOrFail();

        $role->revokePermissionTo('create-administrators');
        $role->revokePermissionTo('view-administrators');
        $role->revokePermissionTo('update-administrators');
        $role->revokePermissionTo('delete-administrators');
    }
}
