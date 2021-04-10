<?php

declare(strict_types=1);


namespace App\Lib\Tests\Pass;

use App\Http\Requests\Tests\Pass\PassTestRequest;
use App\Models\Questions\QuestionType;
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

        $validated['ans_radio'] = collect($validated['ans_radio'] ?? [])
            ->map(
                static function ($item) {
                    $item['is_chosen'] = '1';
                    return $item;
                }
            )
            ->toArray();

        $checkboxed = collect($validated['asked'])
            ->map(
                static function (array $askedQuestion) use ($validated): array {
                    if (QuestionType::CHECKBOXES()
                        ->equalsTo($askedQuestion['question_type'])
                    ) {
                        $askedQuestion['answers'] = $validated['ans'][(int)$askedQuestion['question_id']];
                        return $askedQuestion;
                    }

                    if (QuestionType::RADIO()
                        ->equalsTo($askedQuestion['question_type'])
                    ) {
                        $askedQuestion['answers'] = [
                            $validated['ans_radio'][(int)$askedQuestion['question_id']],
                        ];

                        return $askedQuestion;
                    }
                }
            )
            ->toArray();

        $collection = AskedQuestionDto::createCollection($checkboxed);

        return new self($collection);
    }
}
