<?php


namespace App\Services\Questions\Store\Single;


use App\Models\Question;
use App\Models\Test;
use App\Services\AnswerOptions\Store\StoreAnswerOptionService;

abstract class StoreQuestionService
{
    /** @var array */
    protected $fields = [];

    /** @var StoreAnswerOptionService */
    protected $answerOptionService;

    /**
     * @var Question
     */
    protected $question;

    /**
     * @var Test
     */
    protected $test;

    public function __construct(StoreAnswerOptionService $answerOptionService)
    {
        $this->answerOptionService = $answerOptionService;
    }

    public function ofTest(Test $test)
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

    protected abstract function doHandle(): Question;

    public function clearFields()
    {
        $this->test = null;

        $this->fields = [];

        return $this;
    }
}
