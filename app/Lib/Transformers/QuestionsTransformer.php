<?php


namespace App\Lib\Transformers;


use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class QuestionsTransformer extends RequestDtoModelTransformer
{
    public function requestToDto(array $request, array $set = [])
    {
        return $this->withProperties(
            (object)[
                'question'      => $request['name'] ?? '',
                'answerOptions' => collect($request['v'] ?? [])->map(
                    static function ($variant, $variantId) {
                        return (object)[
                            'id'       => $variantId,
                            'is_right' => $variant['is_right'] ?? false,
                            'text'     => $variant['text'] ?? '',
                        ];
                    }
                )->all(),
            ],
            $set
        );
    }

    public function modelToDto(Model $item, array $setProperties = [])
    {
        if (!$item instanceof Question) {
            throw new InvalidArgumentException("Item must be instance of ".Question::class);
        }

        return $this->withProperties(
            (object)[
                'id'            => $item->id,
                'question'      => $item->question,
                'answerOptions' => $item->answerOptions->map(
                    static function ($option) {
                        return (object)[
                            'id'       => $option->id,
                            'is_right' => $option->is_right,
                            'text'     => $option->text,
                        ];
                    }
                )->all(),
            ],
            $setProperties
        );
    }
}
