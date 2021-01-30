<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Test;

use App\Models\Test;
use App\Rules\Containers\Test\TestTypeRules;
use Laravel\Nova\Fields\Select;

final class TestTypeField
{
    public static function make()
    {
        return Select::make('Тип теста', 'type')
            ->hideFromIndex()
            ->displayUsingLabels()
            ->options(
                array_combine(
                    Test::TYPES,
                    array_map(
                        static fn($t) => __($t),
                        Test::TYPES
                    )
                )
            )->default(Test::TYPE_STANDALONE)
            ->rules(new TestTypeRules());
    }
}
