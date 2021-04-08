<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestResultsTableSeeder extends Seeder
{
    public const TEST_RESULTS_LIMIT = 50_000;

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

        $table = DB::table('test_results');
        for ($i = 1; $i < self::TEST_RESULTS_LIMIT + 1; ++$i) {
            $table->insert(
                [
                    [
                        'test_id' => $faker->numberBetween(1, TestsTableSeeder::TESTS_LIMIT),
                        'user_id' => $faker->numberBetween(1, UsersTableSeeder::USERS_LIMIT)
                    ],
                ]
            );
        }
    }
}
