<?php

declare(strict_types=1);

namespace App\Nova;

use App\Models\Answer as AnswerModel;
use Cdbeaton\BooleanTick\BooleanTick;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
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

            BelongsTo::make('Задане питання', 'askedQuestion', AskedQuestion::class),

            BelongsTo::make('Варіант відповіді', 'answerOption', AnswerOption::class),

            BooleanTick::make('Обрано', 'is_chosen'),
        ];
    }

    public static function label()
    {
        return 'Відповіді';
    }

    public static function singularLabel()
    {
        return 'Обрана відповідь';
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
