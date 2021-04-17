<?php

declare(strict_types=1);

namespace App\Lib\Statements;

use App\Models\Answer;
use App\Models\AnswerOption;
use App\Models\Questions\QuestionType;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class SelectedAnswerPresenter
{
    public const SELECTED_OPTION_LABEL = '*';
    public const SELECTED_RADIO_LABEL = '&';

    private QuestionType $type;

    public function __construct(QuestionType $type)
    {
        $this->type = $type;
    }

    public function labelFor(AnswerOption $option): string
    {
        if (!$option->is_right) {
            return '';
        }

        return $this->presentType();
    }

    public function labelForAnswer(Answer $answer): string
    {
        if (!$answer->is_chosen) {
            return '';
        }

        return $this->presentType();
    }

    private function presentType(): string
    {
        if (QuestionType::CHECKBOXES()
            ->equalsTo($this->type)) {
            return self::SELECTED_OPTION_LABEL;
        }

        if (QuestionType::RADIO()
            ->equalsTo($this->type)) {
            return self::SELECTED_RADIO_LABEL;
        }
    }
}
