<?php

namespace App\Nova;

use App\Rules\Containers\SubjectRulesContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use ZiffMedia\NovaSelectPlus\SelectPlus;

class TestSubject extends Resource
{
    public static $group = 'Tests';

    public static int $groupPriority = 1;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\TestSubject::class;

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

    private SubjectRulesContainer $rulesContainer;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->rulesContainer = app(SubjectRulesContainer::class);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $creationRules = $this->rulesContainer->getRules();
        $updateRules = $this->rulesContainer->getRules();

        $creationRules['uri_alias'][] = 'unique:test_subjects,uri_alias';
        $updateRules['uri_alias'][] = 'unique:test_subjects,uri_alias,{{resourceId}}';

        return [
            ID::make(__('ID'), 'id')->sortable(),
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

            SelectPlus::make('Departments', 'departments', Department::class)
                ->usingDetailLabel('name'),

            SelectPlus::make('Courses', 'courses', Course::class)
                ->label('public_name')
                ->usingDetailLabel('public_name'),

            HasMany::make('Tests'),
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
