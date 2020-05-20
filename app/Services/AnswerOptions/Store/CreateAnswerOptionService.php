<?php


namespace App\Services\AnswerOptions\Store;


use App\Models\AnswerOption;

class CreateAnswerOptionService extends StoreAnswerOptionService
{
    protected function doHandle(): AnswerOption
    {
        return AnswerOption::create($this->fields);
    }
}
