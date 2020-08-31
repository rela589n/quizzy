<?php


namespace App\Services\Questions\Store\Single;


use App\Models\Question;
use App\Models\Test;
use App\Services\AnswerOptions\Store\StoreAnswerOptionService;

abstract class StoreQuestionService
{
    protected array $fields = [];
    protected StoreAnswerOptionService $answerOptionService;
    protected Question $question;
    protected ?Test $test;

    public function __construct(StoreAnswerOptionService $answerOptionService)
    {
        $this->answerOptionService = $answerOptionService;
    }

    /**
     * @param  Test  $test
     * @return $this
     */
    public function ofTest(Test $test): self
    {
        $this->test = $test;

        $this->fields['test_id'] = $test->id;

        return $this;
    }

    public function handle(array $questionInfo): Question
    {
        $this->fields = array_merge($this->fields, $questionInfo);

        $this->question = $this->doHandle();

        foreach ($questionInfo['answerOptions'] as $optionInfo) {
            $this->answerOptionService->ofQuestion($this->question)
                ->handle($optionInfo);
        }

        return $this->question;
    }

    /**
     * @return $this
     */
    public function clearFields(): self
    {
        $this->test = null;

        $this->fields = [];

        return $this;
    }

    abstract protected function doHandle(): Question;
}
