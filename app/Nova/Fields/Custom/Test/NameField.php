<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Test;

use Laravel\Nova\Fields\Text;

final class NameField
{
    public static function make()
    {
        $creationRules = ['name' => []];
        $updateRules = ['name' => []];

        return Text::make('Назва', 'name')
            ->creationRules($creationRules['name'])
            ->updateRules($updateRules['name'])
            ->hideFromDetail()
            ->hideFromIndex();
    }
}
