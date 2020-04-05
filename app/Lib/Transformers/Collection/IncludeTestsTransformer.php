<?php


namespace App\Lib\Transformers\Collection;


class IncludeTestsTransformer extends CollectionTransformer
{
    protected function mapCallback($item, $key)
    {
        return [
            'questions_quantity' => $item['count']
        ];
    }
}
