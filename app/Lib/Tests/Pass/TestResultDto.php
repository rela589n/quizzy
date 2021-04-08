<?php

declare(strict_types=1);


namespace App\Lib\Tests\Pass;

use App\Http\Requests\Tests\Pass\PassTestRequest;
use Illuminate\Support\Collection;

final class TestResultDto
{
    /** @var Collection|AskedQuestionDto[] */
    private Collection $askedQuestions;

    private function __construct(Collection $askedQuestions)
    {
        $this->askedQuestions = $askedQuestions->map(static fn(AskedQuestionDto $dto) => $dto);
    }

    /** @return Collection|AskedQuestionDto */
    public function getAskedQuestions(): Collection
    {
        return $this->askedQuestions;
    }

    public static function create(Collection $askedQuestions): self
    {
        return new self($askedQuestions);
    }

    public static function createFromRequest(PassTestRequest $request): TestResultDto
    {
        $validated = $request->validated();

        $collection = AskedQuestionDto::createCollection(
            array_map(
                static function (array $item) use ($validated) {
                    $item['answers'] = $validated['ans'][(int)$item['question_id']];

                    return $item;
                },
                $validated['asked']
            )
        );

        return new self($collection);
    }
}
