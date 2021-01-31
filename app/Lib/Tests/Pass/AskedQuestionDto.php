<?php

declare(strict_types=1);


namespace App\Lib\Tests\Pass;

use App\Models\AskedQuestion;
use Illuminate\Support\Collection;

final class AskedQuestionDto
{
    private int $questionId;

    /** @var Collection|AnswerDto[] */
    private Collection $answers;

    private function __construct(int $questionId, Collection $answers)
    {
        $this->questionId = $questionId;
        $this->answers = $answers->map(static fn(AnswerDto $dto) => $dto);
    }

    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function mapToModel(): AskedQuestion
    {
        return new AskedQuestion(
            [
                'question_id' => $this->questionId,
            ]
        );
    }

    public static function create(int $questionId, Collection $answers): self
    {
        return new self($questionId, $answers);
    }

    public static function createFromArray(array $item): self
    {
        return self::create(
            (int)$item['question_id'],
            AnswerDto::createCollection($item['answers'])
        );
    }

    public static function createCollection(array $items): Collection
    {
        return collect($items)
            ->map(static fn(array $item) => self::createFromArray($item));
    }
}
