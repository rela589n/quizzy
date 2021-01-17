<?php

declare(strict_types=1);

namespace App\Nova;

use App\Models\Answer as AnswerModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;

final class Answer extends Resource
{
    public static $model = AnswerModel::class;

    public static $title = 'id';

    public static $searchable = false;

    public function fields(Request $request)
    {
        return [
            ID::make(),

            Boolean::make(__('Is Chosen'), 'is_chosen'),

            BelongsTo::make(__('Asked Question'), 'askedQuestion', AskedQuestion::class),

            BelongsTo::make(__('Answer Option'), 'answerOption', AnswerOption::class),
        ];
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
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
