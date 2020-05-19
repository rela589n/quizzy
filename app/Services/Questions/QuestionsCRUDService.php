<?php


namespace App\Services\Questions;


use App\Lib\Transformers\QuestionsTransformer;
use App\Models\Test;
use App\Services\AnswerOptions\Store\CreateAnswerOptionService;
use App\Services\AnswerOptions\Store\UpdateAnswerOptionService;
use App\Services\Questions\Store\Single\CreateQuestionService;
use App\Services\Questions\Store\Single\UpdateQuestionService;

class QuestionsCRUDService
{
    /**
     * @var Test
     */
    protected $test;

    /**
     * @var array
     */
    protected $request;

    /**
     * @var QuestionsTransformer
     */
    protected $questionsTransformer;

    /**
     * @var CreateQuestionService
     */
    protected $createQuestionService;

    /**
     * @var UpdateQuestionService
     */
    private $updateQuestionService;

    /**
     * @var CreateAnswerOptionService
     */
    private $createAnswerOptionService;

    /**
     * @var UpdateAnswerOptionService
     */
    private $updateAnswerOptionService;

    public function __construct(QuestionsTransformer $questionsTransformer,
                                CreateQuestionService $createQuestionService,
//                                UpdateQuestionService $updateQuestionService,
                                CreateAnswerOptionService $createAnswerOptionService,
                                UpdateAnswerOptionService $updateAnswerOptionService)
    {
        $this->questionsTransformer = $questionsTransformer;
        $this->createQuestionService = $createQuestionService;
//        $this->updateQuestionService = $updateQuestionService;
        $this->createAnswerOptionService = $createAnswerOptionService;
        $this->updateAnswerOptionService = $updateAnswerOptionService;
    }

    /**
     * @param Test $test
     * @return QuestionsCRUDService
     */
    public function setTest(Test $test): self
    {
        $this->test = $test;

        return $this;
    }

    public function handle(array $request)
    {
        $this->request = $request;

        $this->performCreate($this->request['q']['new'] ?? []);
    }

    private function performCreate(array $questions)
    {
        foreach ($questions as $questionInfo) {
            $question = $this->createQuestion($questionInfo);

            $question->answerOptions()->createMany($questionInfo['v']);
        }
    }

    private function performModify(array $questions)
    {
        $this->test->loadMissing('nativeQuestions.answerOptions');

        foreach ($questions as $id => $questionInfo) {

            $question = $this->test->nativeQuestions->find($id);

            if ($question === null) {
                $question = $this->createQuestion($questionInfo);
            }

            $question = $this->updateQuestionService->setQuestion($question)
                ->handle($questionInfo);

            foreach ($questionInfo['v'] as $answerOptionId => $answerOptionInfo) {

                $option = $question->answerOptions->find($answerOptionId);

                if ($option === null) {
                    $option = $this->createAnswerOptionService->ofQuestion($question)
                        ->handle($answerOptionInfo);
                }

                $this->updateAnswerOptionService->setAnswerOption($option)
                    ->handle($answerOptionInfo);
            }
        }
    }

    private function createQuestion(array $questionInfo)
    {
        return $this->createQuestionService->ofTest($this->test)
            ->handle(['question' => $questionInfo['name']]);
    }
}
