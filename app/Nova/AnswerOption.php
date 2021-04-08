<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;

class AnswerOption extends Resource
{
    public static $displayInNavigation = false;

    public static $model = \App\Models\AnswerOption::class;

    public static $preventFormAbandonment = true;

    public static $title = 'text';

    public static $search = [
        'id',
    ];

    /** @var \App\Models\AnswerOption */
    public $resource;

    public function fields(Request $request)
    {
        return [
            Text::make('Текст', 'text'),
            Boolean::make('Правильний', 'is_right'),
            BelongsTo::make('Запитання', 'question', Question::class),
        ];
    }

    public static function label()
    {
        return 'Варіанти відповідей';
    }

    public static function singularLabel()
    {
        return 'Варіант відповіді';
    }

    public function authorizedToView(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public static function authorizedToCreate(Request $request): bool
    {
        $editing = $request->get('editing', 'false');

        return 'true' === $editing;
    }

    public function authorizedToDelete(Request $request): bool
    {
        $editing = $request->get('editing', 'false');

        return 'true' === $editing;
    }
}
