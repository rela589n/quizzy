<?php

declare(strict_types=1);

namespace App\Nova\Fields\Custom\Test;

use App\Models\Test;
use JetBrains\PhpStorm\Immutable;
use Laravel\Nova\Fields\Select;

use function array_combine;

#[Immutable]
final class AnswerOptionsOrderField
{
    public const LABELS = [
        Test::ANSWER_OPTION_ORDER_RANDOM => 'Впереміш',
        Test::ANSWER_OPTION_ORDER_SERIATIM => 'По порядку',
    ];

    public static function make()
    {
        return Select::make('Порядок варіантів відповідей', 'answer_options_order')
                     ->hideFromIndex()
                     ->displayUsingLabels()
                     ->options(
                         array_combine(
                             Test::ANSWER_OPTION_ORDERS,
                             self::LABELS,
                         )
                     )->default(Test::ANSWER_OPTION_ORDER_RANDOM);
    }
}
