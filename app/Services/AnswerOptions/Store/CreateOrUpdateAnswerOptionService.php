<?php


namespace App\Services\AnswerOptions\Store;


use App\Models\AnswerOption;
use App\Models\Question;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateOrUpdateAnswerOptionService extends StoreAnswerOptionService
{
    private CreateAnswerOptionService $createAnswerOptionService;
    private UpdateAnswerOptionService $updateAnswerOptionService;

    public function ofQuestion(Question $question): StoreAnswerOptionService
    {
        $question->loadMissing('answerOptions');

        return parent::ofQuestion($question);
    }

    public function __construct(CreateAnswerOptionService $createAnswerOptionService,
                                UpdateAnswerOptionService $updateAnswerOptionService)
    {
        $this->createAnswerOptionService = $createAnswerOptionService;
        $this->updateAnswerOptionService = $updateAnswerOptionService;
    }

    protected function doHandle(): AnswerOption
    {
        try {
            return $this->updateAnswerOptionService
                ->setAnswerOption($this->resolveAnswerOption())
                ->handle($this->fields);

        } catch (ModelNotFoundException $e) {

            return $this->createAnswerOptionService->handle($this->fields);
        }
    }

    protected function resolveAnswerOption()
    {
        if ($this->question !== null && $this->question->relationLoaded('answerOptions')) {

            $option = $this->question->answerOptions->find($this->fields['id']);

            if ($option !== null) {
                return $option;
            }

            throw new ModelNotFoundException("Answer option with id ({$this->fields['id']}) not found.");
        }

        return AnswerOption::findOrFail($this->fields['id']);
    }
}
