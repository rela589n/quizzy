<?php

use App\Models\User;
use Illuminate\Database\Seeder;

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

        $faker = Faker\Factory::create('uk_UA');

        foreach (range(1, self::USERS_LIMIT) as $i) {
            User::create([
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'patronymic' => $faker->lastName,
                'student_group_id' => $faker->numberBetween(1, GroupsTableSeeder::getGroupsCount()),
                'email' => $faker->unique()->userName,
                'password' => Hash::make('1')
            ]);
        }
    }
}
