<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Test;

use App\Nova\TestSubject;
use Laravel\Nova\Fields\BelongsTo;

final class TestSubjectField
{
    public static function make()
    {
        return BelongsTo::make('Предмет', 'subject', TestSubject::class)
            ->sortable();
    }
}
