<?php

namespace App\Nova;

use App\Rules\Containers\GroupRulesContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;

class StudentGroup extends Resource
{
    public static $group = 'Students';

    public static int $groupPriority = 8;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\StudentGroup::class;

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
        'name',
        'uri_alias',
    ];

    private GroupRulesContainer $rulesContainer;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->rulesContainer = app(GroupRulesContainer::class);
    }

    public function fields(Request $request)
    {
        $creationRules = $this->rulesContainer->creationRules();
        $updateRules = $this->rulesContainer->creationRules();///todo

        $updateRules['uri_alias'][] = 'unique:student_groups,uri_alias,{{resourceId}}';

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

            Number::make('Year')
                ->creationRules($creationRules['year'])
                ->updateRules($updateRules['year'])
                ->sortable(),

            Text::make('Name')
                ->creationRules($creationRules['name'])
                ->updateRules($updateRules['name'])
                ->hideFromIndex()
                ->hideFromDetail(),

            Slug::make('Uri Alias')
                ->from('name')
                ->creationRules($creationRules['uri_alias'])
                ->updateRules($updateRules['uri_alias'])
                ->hideFromIndex()
                ->hideFromDetail(),

            HasMany::make('Students', 'students', Student::class),

            BelongsTo::make('Department', 'department', Department::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  Request  $request
     * @return array
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function actions(Request $request): array
    {
        return [];
    }
}
