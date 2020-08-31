<?php


namespace App\Lib\Transformers\Collection;


use Illuminate\Support\Collection;

abstract class CollectionTransformer
{
    /**
     * @param Collection $collection
     * @return Collection
     */
    public function transform($collection): Collection
    {
        return $collection->map(function($item, $key) {
            return $this->mapCallback($item, $key);
        });
    }

    abstract protected function mapCallback ($item, $key);
}
