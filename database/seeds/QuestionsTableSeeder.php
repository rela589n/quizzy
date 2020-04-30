<?php

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    public const QUESTIONS_LIMIT = 40;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') === 'production')
            return;

        Question::create([
            'question' => 'Що таке клас?',
            'test_id' => 1
        ]);

        Question::create([
            'question' => 'Скільки методів може містити клас?',
            'test_id'  => 1
        ]);

        $faker = Faker\Factory::create('uk_UA');
        foreach (range(3, self::QUESTIONS_LIMIT) as $i) {
            Question::create([
                'question' => rtrim($faker->realText(60), ' .') . '?',
                'test_id' => $faker->numberBetween(2, TestsTableSeeder::TESTS_LIMIT)
            ]);
        }
    }
}
