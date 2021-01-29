<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Test;

use Laravel\Nova\Fields\Number;

final class ResultsCountReadOnly
{
    public static function make()
    {
        return Number::make('К-сть результатів', 'test_results_count')
            ->exceptOnForms()
            ->readonly();
    }
}
