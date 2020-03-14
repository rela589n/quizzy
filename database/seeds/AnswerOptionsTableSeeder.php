<?php

use App\Models\AnswerOption;
use App\Models\Question;
use Illuminate\Database\Seeder;

class AnswerOptionsTableSeeder extends Seeder
{
    public const PER_QUESTION_MIN = 2;
    public const PER_QUESTION_MAX = 5;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnswerOption::create([
            'text' => 'це спеціальна конструкція, яка використовується для групування пов\'язаних змінних та функцій.',
            'question_id' => 1,
            'is_right' => true
        ]);

        AnswerOption::create([
            'text' => 'це функція, що дає змогу отримати значення глобальних змінних.',
            'question_id' => 1,
            'is_right' => false
        ]);

        AnswerOption::create([
            'text' => 'це макет, по якому можна створювати об\'єкти.',
            'question_id' => 1,
            'is_right' => true
        ]);

        $faker = Faker\Factory::create('uk_UA');

        $questions = Question::all();
        foreach ($questions as $question) {
            AnswerOption::create([
                'text' => $faker->realText(40),
                'question_id' => $question->id,
                'is_right' => true
            ]);

            foreach(range(2, $faker->numberBetween(self::PER_QUESTION_MIN, self::PER_QUESTION_MAX)) as $i) {
                AnswerOption::create([
                    'text' => $faker->realText(40),
                    'question_id' => $question->id,
                    'is_right' => $faker->boolean()
                ]);
            }
        }
    }
}
