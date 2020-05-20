<?php


namespace App\Services\Questions\Store\Single;


use App\Models\Question;
use App\Services\AnswerOptions\Store\CreateAnswerOptionService;

class CreateQuestionService extends StoreQuestionService
{
    public function __construct(CreateAnswerOptionService $answerOptionService)
    {
        parent::__construct($answerOptionService);
    }

    protected function doHandle(): Question
    {
        return Question::create($this->fields);
    }
}
