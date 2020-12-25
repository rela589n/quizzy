<?php

namespace App\Nova;

use App\Rules\Containers\DepartmentRulesContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Department extends Resource
{
    public static $group = 'Students';

    public static int $groupPriority = 4;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Department::class;

    public static $preventFormAbandonment = true;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'uri_alias',
        'name',
    ];

    /**
     * @param  NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder|\App\Models\Department  $query
     * @return \Illuminate\Database\Eloquent\Builder|void
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withCount('studentGroups');
    }

    /**
     * @param  NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder|\App\Models\Department  $query
     * @return \Illuminate\Database\Eloquent\Builder|void
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return $query->withCount('studentGroups');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $rulesContainer = app(DepartmentRulesContainer::class);

        $creationRules = $rulesContainer->getRules();
        $updateRules = $rulesContainer->getRules();

        $creationRules['uri_alias'][] = 'unique:departments,uri_alias';
        $updateRules['uri_alias'][] = 'unique:departments,uri_alias,{{resourceId}}';

        return [
            ID::make(__('ID'), 'id')
                ->sortable(),

            Stack::make(
                'Name',
                [
                    Line::make('Name')->asHeading(),
                    Line::make('Slug', 'uri_alias')->asSmall(),
                ]
            )->sortable(),

            Text::make('Name')
                ->creationRules($creationRules['name'])
                ->updateRules($updateRules['name'])
                ->hideFromDetail()
                ->hideFromIndex(),

            Slug::make('Uri Alias')
                ->from('name')
                ->creationRules($creationRules['uri_alias'])
                ->updateRules($updateRules['uri_alias'])
                ->hideFromDetail()
                ->hideFromIndex(),

            Number::make('Groups Count', 'student_groups_count')
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            HasMany::make('Student Groups', 'studentGroups', StudentGroup::class),
        ];
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
