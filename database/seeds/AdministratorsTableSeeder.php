<?php

use App\Models\Administrator;
use Illuminate\Database\Seeder;

class AdministratorsTableSeeder extends Seeder
{
    protected static $administrators = [
        'super-admin'   => [
            'system' => [
                'name'       => '',
                'surname'    => 'system',
                'patronymic' => '',
                'password'   => '1',
            ],
            'admin'  => [
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

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
