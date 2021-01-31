<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Test;

use Laravel\Nova\Fields\Number;

final class AttemptsPerUserField
{
    public static function make()
    {
        return Number::make('Обмеження кількості спроб', 'attempts_per_user')
            ->placeholder('Введіть, щоб обмежити')
            ->hideFromIndex()
            ->min(1)
            ->max(1000)
            ->nullable();
    }
}
