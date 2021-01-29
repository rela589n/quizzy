<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Test;

use Laravel\Nova\Fields\Number;

final class PassTimeField
{
    public static function make()
    {
        return Number::make('Час (хвилини)', 'time')
            ->placeholder('')
            ->creationRules([])//todo
            ->sortable();
    }
}
