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
    }
}
