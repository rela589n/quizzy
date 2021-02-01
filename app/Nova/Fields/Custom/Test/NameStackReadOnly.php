<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Test;

use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Stack;

final class NameStackReadOnly
{
    public static function make()
    {
        return Stack::make(
            'Назва',
            'name',
            [
                Line::make('Name', 'name')->asHeading(),
                Line::make('Slug', 'uri_alias')->asSmall(),
            ]
        )->sortable();
    }
}
