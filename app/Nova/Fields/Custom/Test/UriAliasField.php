<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Test;

use App\Rules\Containers\Test\TestUriSlugRules;
use Laravel\Nova\Fields\Slug;

final class UriAliasField
{
    public static function make()
    {
        return Slug::make('Uri-псевдонім', 'uri_alias')
            ->from('name')
            ->creationRules(TestUriSlugRules::forCreate())
            ->updateRules(TestUriSlugRules::forUpdate())
            ->hideFromDetail()
            ->hideFromIndex();
    }
}
