<?php


namespace App\Lib\Transformers\Collection;


class IncludeTestsTransformer extends CollectionTransformer
{
    protected function mapCallback($item, $key): array
    {
        return [
            'questions_quantity' => $item['count']
        ];
    }
}
