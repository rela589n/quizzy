<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Test;

use App\Rules\Containers\Test\TestMarkEvaluatorTypeRules;
use Laravel\Nova\Fields\Select;

final class GradingStrategyField
{
    public static function make()
    {
        return Select::make('Стратегія оцінювання', 'mark_evaluator_type')
            ->displayUsingLabels()
            ->options(
                array_combine(
                    \App\Models\Test::EVALUATOR_TYPES,
                    array_map(
                        static fn($t) => __($t),
                        \App\Models\Test::EVALUATOR_LABELS
                    )
                )
            )->default(\App\Models\Test::EVALUATOR_TYPE_DEFAULT)
            ->rules(new TestMarkEvaluatorTypeRules())
            ->hideFromIndex();
    }
}
