<?php

namespace App\Nova;

use App\Rules\AnswerOptionsRule;
use App\Rules\AtLeastOneSelected;
use Froala\NovaFroalaField\Froala;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Yassi\NestedForm\NestedForm;

class Question extends Resource
{
    public static $group = 'Tests';

    public static $displayInNavigation = false;

    public static $model = \App\Models\Question::class;

    public static $title = 'question';

    public static $preventFormAbandonment = true;

    public static $perPageViaRelationship = 100;

    public function title(): string
    {
        return Str::limit(strip_tags(parent::title()), 75);
    }

    public static $search = [
        'id',
    ];

    /**
     * @param  NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder|\App\Models\Question  $query
     * @return \Illuminate\Database\Eloquent\Builder|void
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->with('test');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make('Запитання')
                ->resolveUsing(fn() => $this->title())
                ->onlyOnIndex(),

            Froala::make('Запитання', 'question')
                ->hideFromIndex()
                ->withFiles('public')
                ->rules(['required']),

            BelongsTo::make('Тест', 'test', Test::class)
                ->exceptOnForms(),

            HasMany::make('Варіанти відповідей', 'answerOptions', AnswerOption::class),
        ];
    }

    public function fieldsForCreate($request)
    {
        return [
            ...$this->fields($request),

            (new NestedForm('Варіант відповіді', 'answerOptions', AnswerOption::class))
                ->rules([new AtLeastOneSelected('is_right')])
                ->showOnDetail()
                ->hideFromIndex()
                ->min(2),
        ];
    }

    public function fieldsForUpdate($request)
    {
        return $this->fieldsForCreate($request);
    }

    public static function label()
    {
        return 'Запитання';
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
