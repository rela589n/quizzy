<?php

declare(strict_types=1);


namespace App\Lib\Tests\Pass;

use App\Models\Answer;
use Illuminate\Support\Collection;

final class AnswerDto
{
    private int $answerOptionId;

    private bool $isChosen;

    private function __construct(int $answerOptionId, bool $isChosen)
    {
        $this->answerOptionId = $answerOptionId;
        $this->isChosen = $isChosen;
    }

    public function getAnswerOptionId(): int
    {
        return $this->answerOptionId;
    }

    public function isChosen(): bool
    {
        return $this->isChosen;
    }

    public function mapToModel(): Answer
    {
        return new Answer(
            [
                'answer_option_id' => $this->answerOptionId,
                'is_chosen'        => $this->isChosen,
            ]
        );
    }

    public static function create(int $answerOptionId, bool $isChosen): self
    {
        return new self($answerOptionId, $isChosen);
    }

    public static function createFromArray(array $item): self
    {
        return self::create((int)$item['answer_option_id'], (bool)($item['is_chosen'] ?? false));
    }

    public static function createCollection(array $items): Collection
    {
        return collect($items)
            ->map(static fn(array $item) => self::createFromArray($item));
    }
}
