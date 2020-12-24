<?php

use Illuminate\Database\Seeder;

class TestResultsTableSeeder extends Seeder
{
    public const TEST_RESULTS_LIMIT = 20_000;

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

        $table = \Illuminate\Support\Facades\DB::table('test_results');
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
