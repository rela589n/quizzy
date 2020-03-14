<?php

use App\Models\TestResult;
use Illuminate\Database\Seeder;

class TestResultsTableSeeder extends Seeder
{
    public const TEST_RESULTS_LIMIT = 300;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('uk_UA');

        foreach(range(1, self::TEST_RESULTS_LIMIT) as $i) {
            TestResult::create([
                'test_id' => $faker->numberBetween(1, TestsTableSeeder::TESTS_LIMIT),
                'user_id' => $faker->numberBetween(1, UsersTableSeeder::USERS_LIMIT)
            ]);
        }
    }
}
