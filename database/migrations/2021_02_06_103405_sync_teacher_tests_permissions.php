<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class SyncTeacherTestsPermissions extends Migration
{
    public function up()
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        /** @var \Spatie\Permission\Models\Role $role */
        $role = \Spatie\Permission\Models\Role::query()->where('name', 'teacher')->firstOrFail();

        $role->givePermissionTo('view-subjects');
        $role->givePermissionTo('update-subjects');
        $role->givePermissionTo('view-tests');
        $role->givePermissionTo('update-tests');
        $role->givePermissionTo('delete-tests');
    }

    public function down()
    {
        /** @var \Spatie\Permission\Models\Role $role */
        $role = \Spatie\Permission\Models\Role::query()->where('name', 'teacher')->firstOrFail();

        $role->revokePermissionTo('view-subjects');
        $role->revokePermissionTo('update-subjects');
        $role->revokePermissionTo('view-tests');
        $role->revokePermissionTo('update-tests');
        $role->revokePermissionTo('delete-tests');
    }
}
