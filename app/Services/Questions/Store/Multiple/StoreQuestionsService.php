<?php


namespace App\Services\Questions\Store\Multiple;


use App\Models\Test as Test;
use App\Services\Questions\Store\Single\StoreQuestionService;

abstract class StoreQuestionsService
{
    /** @var array */
    protected $fields = [];

    /** @var StoreQuestionService */
    protected $storeQuestionService;

    /** @var Test */
    protected $test;

    /**
     * StoreQuestionsService constructor.
     * @param StoreQuestionService $storeQuestionService
     */
    public function __construct(StoreQuestionService $storeQuestionService)
    {
        $this->storeQuestionService = $storeQuestionService;
    }

    public function ofTest(Test $test)
    {
        $this->test = $test;

        $this->fields['test_id'] = $test->id;

        return $this;
    }

    public function handle(array $questionsInfo)
    {
        foreach ($questionsInfo as $questionInfo) {

            $this->storeQuestionService
                ->clearFields();

            if ($this->test !== null) {
                $this->storeQuestionService->ofTest($this->test);
            }

            $this->storeQuestionService->handle($questionInfo);
        }
    }

    public function clearFields()
    {
        $this->test = null;

        $this->fields = [];

        return $this;
    }
}
