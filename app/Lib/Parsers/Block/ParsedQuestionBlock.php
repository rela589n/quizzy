<?php

declare(strict_types=1);

namespace App\Lib\Parsers\Block;

use App\Models\Questions\QuestionType;
use Webmozart\Assert\Assert;

use function array_column;
use function array_first;
use function array_unique;

final class ParsedQuestionBlock
{
    public const CORRECT_CHECKBOXED = 1;
    public const CORRECT_RADIO = 2;

    private const CORRECT = [
        self::CORRECT_CHECKBOXED,
        self::CORRECT_RADIO,
    ];

    private array $question = [];
    private array $answerOptions = [];

    public function __construct() { }

    public static function make(): self
    {
        return new self();
    }

    public function withQuestionText(string $text): self
    {
        $this->question['question'] = $text;

        return $this;
    }

    public function withAnswerOption(string $text, bool $isCorrect, ?int $correctnessReason): self
    {
        if (null !== $correctnessReason) {
            Assert::inArray($correctnessReason, self::CORRECT);
        }

        $this->answerOptions[] = [
            'text' => $text,
            'is_right' => $isCorrect,
            'correctness_reason' => $correctnessReason,
        ];

        return $this;
    }

    public function getQuestion(): array
    {
        $reasons = array_filter(array_column($this->answerOptions, 'correctness_reason'));

        Assert::count(
            array_unique($reasons),
            1,
            "Parse error: Single question can use only one type of selected answers (either * or &). AT Question: {$this->question['question']}",
        );

        if (self::CORRECT_RADIO === array_first($reasons)) {
            Assert::count(
                $reasons,
                1,
                "Parse error: For Radio question type there have to be only one correct answer. AT Question: {$this->question['question']}",
            );

            $this->question['type'] = QuestionType::RADIO();

            return $this->question;
        }

        if (self::CORRECT_CHECKBOXED === array_first($reasons)) {
            Assert::greaterThan(
                $reasons,
                1,
                "Parse error: At least 2 options must be selected as correct. AT Question: {$this->question['question']}",
            );

            $this->question['type'] = QuestionType::CHECKBOXES();

            return $this->question;
        }
    }

    public function getAnswerOptions(): array
    {
        return $this->answerOptions;
    }
}
