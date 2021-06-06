<?php

declare(strict_types=1);

namespace App\Nova\Fields\Custom\Test;

use App\Models\Test;
use JetBrains\PhpStorm\Immutable;
use Laravel\Nova\Fields\Select;

use function array_combine;

#[Immutable]
final class QuestionsOrderField
{
    private const LABELS = [
        Test::QUESTION_ORDER_RANDOM => 'Впереміш',
        Test::QUESTION_ORDER_SERIATIM => 'По порядку',
    ];

    public static function make()
    {
        return Select::make('Порядок питань', 'questions_order')
                     ->hideFromIndex()
                     ->displayUsingLabels()
                     ->options(
                         array_combine(
                             Test::QUESTION_ORDERS,
                             self::LABELS,
                         )
                     )->default(Test::QUESTION_ORDER_RANDOM);
    }
}
