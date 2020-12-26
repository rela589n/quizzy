<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsTableSeeder extends Seeder
{
    public const QUESTIONS_LIMIT = 200 * 40;

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

        $toInsert = [
            [
                'question' => 'Що таке клас?',
                'test_id'  => 1
            ],
            [
                'question' => 'Скільки методів може містити клас?',
                'test_id'  => 1
            ],
        ];

        $faker = Factory::create('uk_UA');

        for ($i = 3; $i < self::QUESTIONS_LIMIT + 1; ++$i) {
            $toInsert[] = [
                'question' => rtrim($faker->realText(60), ' .').'?',
                'test_id'  => $faker->numberBetween(2, TestsTableSeeder::TESTS_LIMIT)
            ];
        }

        DB::table('questions')->insert($toInsert);
    }
}
