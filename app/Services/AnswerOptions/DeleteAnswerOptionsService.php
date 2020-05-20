<?php


namespace App\Services\AnswerOptions;


use App\Models\AnswerOption;

class DeleteAnswerOptionsService
{
    public function handle(array $ids): void
    {
        if (count($ids) > 0) {
            AnswerOption::whereIn('id', $ids)->delete();
        }
    }
}
