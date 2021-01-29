<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Test;

use Laravel\Nova\Fields\Select;

final class TestTypeField
{
    public static function make()
    {
        return Select::make('Тип теста', 'type')
            ->hideFromIndex()
            ->displayUsingLabels()
            ->default(\App\Models\Test::TYPE_STANDALONE)
            ->options(
                array_combine(
                    \App\Models\Test::TYPES,
                    array_map(
                        static fn($t) => __($t),
                        \App\Models\Test::TYPES
                    )
                )
            );
    }
}
