<?php


namespace App\Services\Questions;


use App\Models\Question;

class DeleteQuestionsService
{
    public function handle(array $ids): void
    {
        if (count($ids) > 0) {
            Question::whereIn('id', $ids)->delete();
        }
    }
}
