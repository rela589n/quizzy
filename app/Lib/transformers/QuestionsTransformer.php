<?php


namespace App\Lib\transformers;


use App\Models\Question;
use Illuminate\Database\Eloquent\Model;

class QuestionsTransformer extends RequestDtoModelTransformer
{
    public function requestToDto(array $request, array $set = [])
    {
        return $this->withProperties((object)[
            'question' => $request['name'] ?? '',
            'answerOptions' => collect($request['v'] ?? [])->map(function ($variant, $variantId) {
                return (object)[
                    'id' => $variantId,
                    'is_right' => $variant['is_right'] ?? false,
                    'text' => $variant['text'] ?? '',
                ];
            })->all(),
        ], $set);
    }

    public function modelToDto(Model $item, array $setProperties = [])
    {
        if (!$item instanceof Question) {
            throw new \InvalidArgumentException("Item must be instance of " . Question::class);
        }

        return $this->withProperties((object)[
            'id' => $item->id,
            'question' => $item->question,
            'answerOptions' => $item->answerOptions->map(function ($option) use ($item) {
                return (object)[
                    'id' => $option->id,
                    'is_right' => $option->is_right,
                    'text' => $option->text,
                ];
            })->all(),
        ], $setProperties);
    }
}
