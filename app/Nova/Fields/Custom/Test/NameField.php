<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Test;

use App\Rules\Containers\Test\TestNameRules;
use Laravel\Nova\Fields\Text;

final class NameField
{
    public static function make()
    {
        return Text::make('Назва', 'name')
            ->rules(new TestNameRules())
            ->hideFromDetail()
            ->hideFromIndex();
    }
}
