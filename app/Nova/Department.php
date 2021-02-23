<?php

namespace App\Nova;

use App\Models\Departments\DepartmentEloquentBuilder;
use App\Rules\Containers\Department\DepartmentNameRules;
use App\Rules\Containers\Department\DepartmentUriSlugRules;
use App\Rules\Containers\DepartmentRulesContainer;
use Illuminate\Database\Eloquent\Builder;
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
     * @param  DepartmentEloquentBuilder  $query
     * @return Builder|void
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query
            ->with('studentGroups')
            ->withCount('studentGroups')
            ->availableForAdmin($request->user());
    }

    /**
     * @param  NovaRequest  $request
     * @param  Builder|\App\Models\Department  $query
     * @return Builder|void
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return $query->withCount('studentGroups');
    }

    public function fields(Request $request): array
    {
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
                ->creationRules(DepartmentNameRules::forCreate())
                ->updateRules(DepartmentNameRules::forUpdate())
                ->hideFromDetail()
                ->hideFromIndex(),

            Slug::make('Uri-псевдонім', 'uri_alias')
                ->from('name')
                ->creationRules(DepartmentUriSlugRules::forCreate())
                ->updateRules(DepartmentUriSlugRules::forUpdate())
                ->hideFromDetail()
                ->hideFromIndex(),

            Number::make('Кількість груп', 'student_groups_count')
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            HasMany::make('Групи студентів', 'studentGroups', StudentGroup::class),
        ];
    }

    /**
     * @param  NovaRequest  $request
     * @param  Builder  $query
     * @return Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query)
            ->availableForAdmin($request->user());
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
