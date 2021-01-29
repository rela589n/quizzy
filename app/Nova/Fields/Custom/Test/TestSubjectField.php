<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Test;

use Laravel\Nova\Fields\BelongsTo;

final class TestSubjectField
{
    public static function make()
    {
        return BelongsTo::make('Test Subject', 'subject')
            ->sortable();
    }
}
