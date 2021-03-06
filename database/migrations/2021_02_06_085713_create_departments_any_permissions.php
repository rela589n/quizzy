<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

final class CreateDepartmentsAnyPermissions extends Migration
{
    private const PERMISSIONS = [
        [
            'guard_name'  => 'admin',
            'name'        => 'create-departments',
            'public_name' => 'Створення відділень',
        ],
        [
            'guard_name'  => 'admin',
            'name'        => 'view-all-departments',
            'public_name' => 'Перегляд будь-яких відділень',
        ],
        [
            'guard_name'  => 'admin',
            'name'        => 'update-all-departments',
            'public_name' => 'Оновлення будь-яких відділень',
        ],
        [
            'guard_name'  => 'admin',
            'name'        => 'delete-all-departments',
            'public_name' => 'Видалення будь-яких відділень',
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
