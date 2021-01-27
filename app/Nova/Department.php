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
    public static $group = 'Студенти';

    public static int $groupPriority = 4;

    public static $model = \App\Models\Department::class;

    public static $preventFormAbandonment = true;

    public static $title = 'name';

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

    public function fields(Request $request): array
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
                'Назва',
                [
                    Line::make('Name')->asHeading(),
                    Line::make('Slug', 'uri_alias')->asSmall(),
                ]
            )->sortable(),

            Text::make('Назва', 'name')
                ->creationRules($creationRules['name'])
                ->updateRules($updateRules['name'])
                ->hideFromDetail()
                ->hideFromIndex(),

            Slug::make('Uri-псевдонім', 'uri_alias')
                ->from('name')
                ->creationRules($creationRules['uri_alias'])
                ->updateRules($updateRules['uri_alias'])
                ->hideFromDetail()
                ->hideFromIndex(),

            Number::make('Кількість груп', 'student_groups_count')
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            HasMany::make('Групи студентів', 'studentGroups', StudentGroup::class),
        ];
    }

    public static function label(): string
    {
        return 'Відділення';
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
