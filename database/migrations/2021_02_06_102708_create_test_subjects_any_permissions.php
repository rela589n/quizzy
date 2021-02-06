<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

final class CreateTestSubjectsAnyPermissions extends Migration
{
    private const PERMISSIONS = [
        [
            'guard_name'  => 'admin',
            'name'        => 'view-all-subjects',
            'public_name' => 'Перегляд будь-яких предметів тестування',
        ],
        [
            'guard_name'  => 'admin',
            'name'        => 'update-all-subjects',
            'public_name' => 'Оновлення будь-яких предметів тестування',
        ],
        [
            'guard_name'  => 'admin',
            'name'        => 'delete-all-subjects',
            'public_name' => 'Видалення будь-яких предметів тестування',
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
