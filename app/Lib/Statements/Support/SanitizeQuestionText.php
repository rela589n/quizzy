<?php

declare(strict_types=1);

namespace App\Lib\Statements\Support;

use App\Models\Question;
use JetBrains\PhpStorm\Immutable;

use function html_entity_decode;
use function strip_tags;

final class SanitizeQuestionText
{
    private bool $shouldStripHtml = false;

    public function shouldStripHtml(bool $shouldStripHtml = true): void
    {
        $this->shouldStripHtml = $shouldStripHtml;
    }

    public function __invoke(Question $question)
    {
        if ($this->shouldStripHtml) {
            return html_entity_decode(strip_tags(($question->question)));
        }

        return $question->question;
    }
}
