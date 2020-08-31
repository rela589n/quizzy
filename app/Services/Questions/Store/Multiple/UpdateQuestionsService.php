<?php


namespace App\Services\Questions\Store\Multiple;


use App\Models\Test;
use App\Services\Questions\Store\Single\UpdateQuestionService;

class UpdateQuestionsService extends StoreQuestionsService
{
    public function __construct(UpdateQuestionService $updateQuestionService)
    {
        parent::__construct($updateQuestionService);
    }

    public function ofTest(Test $test): self
    {
        $test->loadMissing('nativeQuestions.answerOptions');

        return parent::ofTest($test);
    }
}
