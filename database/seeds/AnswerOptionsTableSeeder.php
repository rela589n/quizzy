<?php

namespace Database\Seeders;

use App\Models\Question;
use DB;
use Faker\Factory;
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
    public function run(): void
    {
        if (env('APP_ENV') === 'production') {
            return;
        }

        $faker = Factory::create('uk_UA');

        DB::table('questions')
            ->orderBy('id')
            ->chunk(
                256,
                function ($questions) use ($faker) {
                    $answerOptionsToInsert = [];

                    foreach ($questions as $question) {
                        $answerOptionsToInsert[] = [
                            'text'        => $faker->realText(40),
                            'question_id' => $question->id,
                            'is_right'    => true
                        ];

                        foreach (
                            range(
                                2,
                                $faker->numberBetween(self::PER_QUESTION_MIN, self::PER_QUESTION_MAX)
                            ) as $i
                        ) {
                            $answerOptionsToInsert[] = [
                                'text'        => $faker->realText(40),
                                'question_id' => $question->id,
                                'is_right'    => $faker->boolean()
                            ];
                        }
                    }

                    DB::table('answer_options')->insert($answerOptionsToInsert);
                }
            );

        $question = Question::find(1);
        $question->answerOptions()->delete();

        $question->answerOptions()->createMany(
            [
                [
                    'text'     => 'це спеціальна конструкція, яка використовується для групування пов\'язаних змінних та функцій.',
                    'is_right' => true
                ],
                [
                    'text'     => 'це функція, що дає змогу отримати значення глобальних змінних.',
                    'is_right' => false
                ],
                [
                    'text'     => 'це макет, по якому можна створювати об\'єкти.',
                    'is_right' => true
                ]
            ]
        );

        $question = Question::find(2);
        $question->answerOptions()->delete();

        $question->answerOptions()->createMany(
            [
                [
                    'text'     => 'Лише 1',
                    'is_right' => false
                ],
                [
                    'text'     => 'Скільки потрібно',
                    'is_right' => true
                ],
                [
                    'text'     => 'Скільки визначить програміст',
                    'is_right' => false
                ]
            ]
        );
    }
}
