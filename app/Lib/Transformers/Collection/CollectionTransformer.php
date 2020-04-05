<?php


namespace App\Lib\Transformers\Collection;


use Illuminate\Support\Collection;

abstract class CollectionTransformer
{
    /**
     * @param Collection $collection
     * @return Collection
     */
    public function transform($collection)
    {
        return $collection->map(function($item, $key) {
            return $this->mapCallback($item, $key);
        });
    }

    protected abstract function mapCallback ($item, $key);
}
