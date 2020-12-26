<?php


namespace App\Nova\Fields;


final class BelongsTo extends \Laravel\Nova\Fields\BelongsTo
{
    public function sortableUriKey()
    {
        return $this->attribute;
    }
}
