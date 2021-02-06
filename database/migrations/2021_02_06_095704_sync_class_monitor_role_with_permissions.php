<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

final class SyncClassMonitorRoleWithPermissions extends Migration
{
    public function up()
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        /** @var \Spatie\Permission\Models\Role $role */
        $role = \Spatie\Permission\Models\Role::query()->where('name', 'class-monitor')->firstOrFail();

        $role->givePermissionTo('create-groups');
        $role->givePermissionTo('view-groups');
        $role->givePermissionTo('update-groups');
        $role->givePermissionTo('delete-groups');
        $role->givePermissionTo('view-departments');
        $role->givePermissionTo('create-students');
        $role->givePermissionTo('view-students');
        $role->givePermissionTo('update-students');
        $role->givePermissionTo('delete-students');
    }

    public function down()
    {
        /** @var \Spatie\Permission\Models\Role $role */
        $role = \Spatie\Permission\Models\Role::query()->where('name', 'class-monitor')->firstOrFail();

        $role->revokePermissionTo('create-groups');
        $role->revokePermissionTo('view-groups');
        $role->revokePermissionTo('update-groups');
        $role->revokePermissionTo('delete-groups');
        $role->revokePermissionTo('view-departments');
        $role->revokePermissionTo('create-students');
        $role->revokePermissionTo('view-students');
        $role->revokePermissionTo('update-students');
        $role->revokePermissionTo('delete-students');
    }
}
