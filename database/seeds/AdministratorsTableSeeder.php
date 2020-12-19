<?php

use App\Models\Administrator;
use Illuminate\Database\Seeder;

class AdministratorsTableSeeder extends Seeder
{
    protected static array $administrators = [
        'super-admin'   => [
            'system@example.com' => [
                'name'       => '',
                'surname'    => 'system',
                'patronymic' => '',
                'password'   => '1',
            ],
            'admin@example.com'  => [
                'name'       => 'Євген',
                'surname'    => 'Григоровський',
                'patronymic' => 'Сергійович',
                'password'   => '1'
            ],
        ],
        'teacher'       => [
            'iryna-hutnyk' => [
                'name'       => 'Ірина',
                'surname'    => 'Гутник',
                'patronymic' => 'Іванівна',
                'password'   => '1'
            ]
        ],
        'class-monitor' => [
            'sand' => [
                'name'       => 'Олександр',
                'surname'    => 'Моїк',
                'patronymic' => 'Ігорович',
                'password'   => '1',
            ]
        ]
    ];

    protected static array $productionOnly = ['super-admin'];

    public function __construct()
    {
        if (env('APP_ENV') === 'production') {
            // seed only those from $productionOnly
            self::$administrators = array_intersect_key(
                self::$administrators,
                array_flip(self::$productionOnly)
            );
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (static::$administrators as $roleName => $users) {
            foreach ($users as $userName => $info) {
                $info['email'] = $userName;
                $info['password'] = Hash::make($info['password']);

                Administrator::create($info)
                    ->assignRole($roleName);
            }
        }
    }
}
