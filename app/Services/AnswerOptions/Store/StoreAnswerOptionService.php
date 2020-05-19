<?php


namespace App\Services\AnswerOptions\Store;


use App\Models\AnswerOption;
use App\Models\Question;

abstract class StoreAnswerOptionService
{
    /** @var array */
    protected $fields = [];

    /** @var AnswerOption */
    protected $answerOption;

    /** @var Question */
    protected $question;

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

    protected abstract function doHandle(): AnswerOption;

    public function clearFields()
    {
        $this->question = null;

        $this->fields = [];

        return $this;
    }
}
