<?php

use App\Models\AskedQuestion;
use App\Models\TestResult;
use Illuminate\Database\Seeder;

class AskedQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(1, TestResultsTableSeeder::TEST_RESULTS_LIMIT) as $resultId) {
            $testResult = TestResult::find($resultId);

            foreach ($testResult->test->allQuestions() as $question) {
                AskedQuestion::create([
                    'test_result_id' => $testResult->id,
                    'question_id' => $question->id
                ]);
            }
        }
    }
}
