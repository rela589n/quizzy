<?php

declare(strict_types=1);

namespace App\Lib\Tests\Presenter;

use App\Models\Question;
use JetBrains\PhpStorm\Immutable;

use function strip_tags;

#[Immutable]
final class QuestionPresenter
{
    private Question $question;

    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    public function plainText(): string
    {
        return strip_tags($this->question->question);
    }
}
