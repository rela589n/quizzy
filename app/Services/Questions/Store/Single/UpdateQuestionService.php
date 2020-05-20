<?php


namespace App\Services\Questions\Store\Single;


use App\Models\Question;
use App\Services\AnswerOptions\Store\CreateOrUpdateAnswerOptionService;

class UpdateQuestionService extends StoreQuestionService
{
    public function __construct(CreateOrUpdateAnswerOptionService $answerOptionService)
    {
        parent::__construct($answerOptionService);
    }

    protected function doHandle(): Question
    {
        $this->receiveQuestion()->update($this->fields);

        return $this->question;
    }

    protected function receiveQuestion(): Question
    {
        if ($this->test !== null && $this->test->relationLoaded('nativeQuestions')) {
            $this->question = $this->test->nativeQuestions->find($this->fields['id']);

            if ($this->question !== null) {
                return $this->question;
            }
        }

        return ($this->question = Question::findOrFail($this->fields['id']));
    }
}
