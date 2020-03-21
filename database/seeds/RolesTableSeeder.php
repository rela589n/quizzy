<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    protected $roles = [
        'admin' => [
            'super-admin' => [
                'public_name' => 'Адміністратор',
            ],
            'teacher' => [
                'public_name' => 'Викладач',
                'permissions' => [
                    'create-groups',
                    'view-groups',
                    'update-groups',
                    'delete-groups',

                    'create-students',
                    'view-students',
                    'update-students',
                    'delete-students',

                    'create-subjects',
                    'view-subjects',
                    'update-subjects',

                    'create-tests',
                    'view-tests',
                    'update-tests',

                    'view-results',
                    'generate-group-statement',
                    'generate-student-statement',
                ]
            ]
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $guardName => $roles) {

            foreach ($roles as $name => $roleConfig) {

                /**
                 * @var Role $role
                 */
                $role = Role::create([
                    'guard_name' => $guardName,
                    'name' => $name,
                    'public_name' => $roleConfig['public_name']
                ]);

                $permissions = Permission::whereIn(
                    'name',
                    $roleConfig['permissions'] ?? []
                )->get();

                $role->syncPermissions($permissions);
            }
        }
    }
}
