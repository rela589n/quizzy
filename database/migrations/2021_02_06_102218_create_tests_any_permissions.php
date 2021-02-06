<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateTestsAnyPermissions extends Migration
{
    private const PERMISSIONS = [
        [
            'guard_name'  => 'admin',
            'name'        => 'view-all-tests',
            'public_name' => 'Перегляд будь-яких тестів',
        ],
        [
            'guard_name'  => 'admin',
            'name'        => 'update-all-tests',
            'public_name' => 'Оновлення будь-яких тестів',
        ],
        [
            'guard_name'  => 'admin',
            'name'        => 'delete-all-tests',
            'public_name' => 'Видалення будь-яких тестів',
        ],
    ];

    public function up(): void
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (self::PERMISSIONS as $permissionData) {
            /** @var \Spatie\Permission\Models\Permission $permission */
            $permission = \Spatie\Permission\Models\Permission::create($permissionData);
        }
    }

    public function down(): void
    {
        foreach (self::PERMISSIONS as $permissionData) {
            \Spatie\Permission\Models\Permission::query()->where('name', $permissionData['name'])
                ->delete();
        }
    }
}
