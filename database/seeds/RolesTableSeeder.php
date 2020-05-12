<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    protected static $roles = [
        'admin' => [
            'super-admin'   => [
                'public_name' => 'Адміністратор',
            ],
            'teacher'       => [
                'public_name'        => 'Викладач',
                'permissions-type'   => 'all', // all | only
                'permissions-except' => [
                    'access-administrators',
                    'create-administrators',
                    'view-administrators',
                    'update-administrators',
                    'delete-administrators',

                    'update-subjects',
                    'delete-subjects',

                    'update-tests',
                    'delete-tests',

                    'create-departments',
                    'update-departments',
                    'delete-departments',
                ]
            ],
            'class-monitor' => [
                'public_name'      => 'Староста',
                'permissions-only' => [
                    'access-groups',

                    'create-students',
                ]
            ]
        ]
    ];

    /**
     * @return array
     */
    public static function getRoles(): array
    {
        return static::$roles;
    }

    public static function init()
    {
        foreach (static::$roles as $guardName => $roles) {
            foreach ($roles as $name => $config) {
                $permissionsAlias = &static::$roles[$guardName][$name]['permissions'];

                $type = $config['permissions-type'] ?? 'only';
                if ($type === 'all') {
                    $permissionsAlias = array_keys(PermissionsTableSeeder::getPermissions()[$guardName]);
                }

                $permissionsAlias = ($permissionsAlias ?? []) + ($config['permissions-only'] ?? []);
                $permissionsAlias = array_diff($permissionsAlias, $config['permissions-except'] ?? []);
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        static::init();

        foreach (static::$roles as $guardName => $roles) {

            foreach ($roles as $name => $roleConfig) {

                /**
                 * @var Role $role
                 */
                $role = Role::firstOrCreate([
                    'name' => $name,
                    'guard_name'  => $guardName,
                ], [
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
