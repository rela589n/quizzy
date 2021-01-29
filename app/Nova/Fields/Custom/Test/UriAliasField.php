<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Test;

use Laravel\Nova\Fields\Slug;

final class UriAliasField
{
    public static function make()
    {
        $creationRules = ['uri_alias' => []];
        $updateRules = ['uri_alias' => []];

        return Slug::make('Uri-псевдонім', 'uri_alias')
            ->from('name')
            ->creationRules($creationRules['uri_alias'])
            ->updateRules($updateRules['uri_alias'])
            ->hideFromDetail()
            ->hideFromIndex();
    }
}
