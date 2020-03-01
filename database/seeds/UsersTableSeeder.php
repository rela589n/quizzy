<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Анатолій',
            'surname' => 'Кармелюк',
            'patronymic' => 'Давидович',
            'student_group_id' => 1,
            'email' => 'student',
            'password' => Hash::make('password')
        ]);
    }
}
