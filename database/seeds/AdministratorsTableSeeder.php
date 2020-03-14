<?php

use App\Models\Administrator;
use Illuminate\Database\Seeder;

class AdministratorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Administrator::create([
            'name' => 'Євген',
            'surname' => 'Григоровський',
            'patronymic' => 'Сергійович',
            'email' => 'admin',
            'password' => Hash::make('password')
        ]);

        Administrator::create([
            'name' => 'system',
            'surname' => 'system',
            'patronymic' => 'system',
            'email' => 'system',
            'password' => Hash::make('Gfhjkm_Rehcfx'),
            'password_changed' => 1
        ]);
    }
}
