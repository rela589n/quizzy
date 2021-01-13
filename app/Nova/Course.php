<?php

declare(strict_types=1);

namespace App\Nova;

use App\Models\Course as CourseModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

final class Course extends Resource
{
    public static $model = CourseModel::class;

    public static $displayInNavigation = false;

    public static $title = 'public_name';

    public static $search = [
        'id',
        'public_name'
    ];

    public function fields(Request $request)
    {
        return [
            ID::make(),

            Text::make('Public Name')
                ->rules('required'),
        ];
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [];
    }
}
