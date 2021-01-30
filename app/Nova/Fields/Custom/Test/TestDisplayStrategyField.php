<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Test;

use App\Models\Test;
use App\Rules\Containers\Test\TestDisplayStrategyRules;
use App\Rules\Containers\Test\TestTypeRules;
use Laravel\Nova\Fields\Select;

final class TestDisplayStrategyField
{
    public static function make()
    {
        return Select::make('Виведення питань', 'display_strategy')
            ->hideFromIndex()
            ->displayUsingLabels()
            ->options(
                array_combine(
                    Test::DISPLAY_STRATEGIES,
                    array_map(
                        static fn($s) => __('tests.strategies.'.$s),
                        Test::DISPLAY_STRATEGIES
                    )
                )
            )->default(Test::DISPLAY_ONE_BY_ONE)
            ->rules(new TestDisplayStrategyRules());
    }
}
