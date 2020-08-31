<?php


namespace App\Services\AnswerOptions\Store;


use App\Models\AnswerOption;
use App\Models\Question;

abstract class StoreAnswerOptionService
{
    protected array $fields = [];
    protected ?AnswerOption $answerOption;
    protected ?Question $question;

    public function ofQuestion(Question $question): self
    {
        $this->question = $question;

        $this->fields['question_id'] = $question->id;

        return $this;
    }

    public function handle(array $option): AnswerOption
    {
        $this->fields = array_merge($this->fields, $option);

        $this->answerOption = $this->doHandle();

        return $this->answerOption;
    }

    abstract protected function doHandle(): AnswerOption;

    /**
     * @return $this
     */
    public function clearFields(): StoreAnswerOptionService
    {
        $this->question = null;

        $this->fields = [];

        return $this;
    }
}
