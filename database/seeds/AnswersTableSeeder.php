<?php

use App\Models\AskedQuestion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class AnswersTableSeeder extends Seeder
{
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

        /**
         * @var $askedQuestions AskedQuestion[]
         */

        $faker = Faker\Factory::create('uk_UA');
        $table = \Illuminate\Support\Facades\DB::table('answers');

        AskedQuestion::with('question.answerOptions')->chunk(
            64,
            function ($askedQuestions) use ($faker, $table) {
                /** @var Collection|AskedQuestion[] $askedQuestions */

                $answersToInsert = [];

                foreach ($askedQuestions as $askedQuestion) {
                    foreach ($askedQuestion->question->answerOptions as $answerOption) {
                        $chance = $answerOption->is_right ? 95 : 5;

                        $answersToInsert [] = [
                            'asked_question_id' => $askedQuestion->id,
                            'answer_option_id'  => $answerOption->id,
                            'is_chosen'         => $faker->boolean($chance)
                        ];
                    }
                }

                $table->insert($answersToInsert);
            }
        );
    }
}
