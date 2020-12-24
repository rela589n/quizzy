<?php

use App\Models\TestResult;
use Illuminate\Database\Seeder;

class AskedQuestionsTableSeeder extends Seeder
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

        $table = \Illuminate\Support\Facades\DB::table('asked_questions');

        TestResult::with('test.testComposites.questions')
            ->chunk(
                32,
                function ($results) use ($table) {
                    $askedQuestionsToInsert = [];

                    foreach ($results as $testResult) {
                        foreach ($testResult->test->allQuestions() as $question) {
                            $askedQuestionsToInsert[] = [
                                'test_result_id' => $testResult->id,
                                'question_id'    => $question->id
                            ];
                        }
                    }

                    $table->insert($askedQuestionsToInsert);
                }
            );
    }
}
