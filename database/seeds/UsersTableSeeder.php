<?php

namespace Database\Seeders;

use Faker\Factory;
use Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public const USERS_LIMIT = 80;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        if (env('APP_ENV') === 'production') {
            return;
        }

        $faker = Factory::create('uk_UA');
        $password = Hash::make('1');

        $table = DB::table('users');

        for ($i = 1; $i < self::USERS_LIMIT + 1; ++$i) {
            $table->insert(
                [
                    [
                        'name' => $faker->firstName,
                        'surname' => $faker->lastName,
                        'patronymic' => $faker->lastName,
                        'student_group_id' => $faker->numberBetween(1, GroupsTableSeeder::getGroupsCount()),
                        'email' => $faker->unique()->userName,
                        'password' => $password
                    ]
                ]
            );
        }
    }
}
