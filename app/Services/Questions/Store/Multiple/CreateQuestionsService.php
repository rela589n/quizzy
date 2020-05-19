<?php


namespace App\Services\Questions\Store\Multiple;


use App\Services\Questions\Store\Single\CreateQuestionService;

class CreateQuestionsService extends StoreQuestionsService
{
    public function __construct(CreateQuestionService $createQuestionService)
    {
        parent::__construct($createQuestionService);
    }
}
