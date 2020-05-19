<?php


namespace App\Services\AnswerOptions\Store;


use App\Models\AnswerOption;

class UpdateAnswerOptionService extends StoreAnswerOptionService
{
    /**
     * @param AnswerOption $answerOption
     * @return UpdateAnswerOptionService
     */
    public function setAnswerOption(AnswerOption $answerOption): self
    {
        $this->answerOption = $answerOption;

        return $this;
    }

    protected function doHandle(): AnswerOption
    {
        $this->answerOption->update($this->fields);

        return $this->answerOption;
    }
}
