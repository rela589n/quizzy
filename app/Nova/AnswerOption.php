<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class AnswerOption extends Resource
{
    public static $displayInNavigation = false;

    public static $model = \App\Models\AnswerOption::class;

    public static $preventFormAbandonment = true;

    public static $title = 'text';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /** @var \App\Models\AnswerOption */
    public $resource;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('Text'),
            Boolean::make('Is Right'),
            BelongsTo::make('Question', 'question', Question::class),
        ];
    }

    public function authorizedToView(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public static function authorizedToCreate(Request $request)
    {
        return isset($request->viaResource);
    }

    public function authorizedToDelete(Request $request)
    {
        return !isset($request->viaResource);
    }
}
