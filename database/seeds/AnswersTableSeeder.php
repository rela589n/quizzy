<?php

use App\Models\Answer;
use App\Models\AskedQuestion;
use Illuminate\Database\Seeder;

class AnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var $askedQuestions AskedQuestion[]
         */

        $faker = Faker\Factory::create('uk_UA');
        $askedQuestions = AskedQuestion::with('question.answerOptions')->get();

        foreach ($askedQuestions as $askedQuestion) {
            foreach ($askedQuestion->question->answerOptions as $answerOption) {
                $chance = $answerOption->is_right ? 85 : 15;

                Answer::create([
                    'asked_question_id' => $askedQuestion->id,
                    'answer_option_id' => $answerOption->id,
                    'is_chosen' =>  $faker->boolean($chance)
                ]);
            }
        }
    }
}
