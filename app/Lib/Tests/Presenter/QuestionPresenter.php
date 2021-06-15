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
    private bool $shouldDecodeEntities;

    public function __construct(Question $question, bool $shouldDecodeEntities)
    {
        $this->question = $question;
        $this->shouldDecodeEntities = $shouldDecodeEntities;
    }

    public function plainText(): string
    {
        return with(
            strip_tags($this->question->question),
            $this->shouldDecodeEntities ? static fn(string $str) => html_entity_decode($str) : null
        );
    }
}
