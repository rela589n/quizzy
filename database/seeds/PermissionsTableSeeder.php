<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    protected static $permissions = [
        'admin' => [
            'create-administrators' => [
                'public_name' => 'Реєстрація адміністраторів'
            ],
            'view-administrators' => [
                'public_name' => 'Перегляд адміністраторів'
            ],
            'update-administrators' => [
                'public_name' => 'Редагування адміністраторів'
            ],
            'delete-administrators' => [
                'public_name' => 'Видалення адміністраторів'
            ],


            'create-groups' => [
                'public_name' => 'Створення груп'
            ],
            'view-groups' => [
                'public_name' => 'Перегляд груп'
            ],
            'update-groups' => [
                'public_name' => 'Налаштування груп'
            ],
            'delete-groups' => [
                'public_name' => 'Видалення груп'
            ],


            'create-students' => [
                'public_name' => 'Реєстрація студентів'
            ],
            'view-students' => [
                'public_name' => 'Перегляд студентів'
            ],
            'update-students' => [
                'public_name' => 'Редагування студентів'
            ],
            'delete-students' => [
                'public_name' => 'Видалення студенів'
            ],


            'create-subjects' => [
                'public_name' => 'Створення предметів тестування'
            ],
            'view-subjects' => [
                'public_name' => 'Перегляд предметів тестування'
            ],
            'update-subjects' => [
                'public_name' => 'Налаштування предметів тестування'
            ],
            'delete-subjects' => [
                'public_name' => 'Видалення предметів тестування'
            ],


            'create-tests' => [
                'public_name' => 'Створення тестів'
            ],
            'view-tests' => [
                'public_name' => 'Перегляд тестів'
            ],
            'update-tests' => [
                'public_name' => 'Налаштування тестів'
            ],
            'delete-tests' => [
                'public_name' => 'Видалення тестів'
            ],


            'view-results' => [
                'public_name' => 'Перегляд результатів'
            ],
            'generate-group-statement' => [
                'public_name' => 'Створення відомості по групі'
            ],
            'generate-student-statement' => [
                'public_name' => 'Створення відомості по студенту'
            ],
        ]
    ];

    /**
     * @return array
     */
    public static function getPermissions(): array
    {
        return static::$permissions;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (static::$permissions as $guardName => $permissions) {

            foreach ($permissions as $name => $permission) {

                Permission::create([
                    'guard_name' => $guardName,
                    'name' => $name,
                    'public_name' => $permission['public_name']
                ]);
            }
        }
    }
}
