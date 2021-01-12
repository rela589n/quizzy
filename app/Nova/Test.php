<?php

namespace App\Nova;

use App\Models\MarkPercent;
use App\Rules\Containers\TestRulesContainer;
use App\Services\Tests\Grading\GradingTableService;
use Eminiarts\Tabs\Tabs;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Fourstacks\NovaRepeatableFields\Repeater;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Test extends Resource
{
    public static $group = 'Tests';

    public static int $groupPriority = 2;

    public static $model = \App\Models\Test::class;

    /** @var \App\Models\Test */
    public $resource;

    public static $title = 'name';

    public static $preventFormAbandonment = true;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
    ];

    private TestRulesContainer $rulesContainer;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->rulesContainer = app(TestRulesContainer::class);
    }

    /**
     * @param  NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder|\App\Models\Test  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withCount('testResults')
            ->with('subject')
            ->with('marksPercents');
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

        $creationRules['uri_alias'][] = 'unique:tests,uri_alias';
        $updateRules['uri_alias'][] = 'unique:tests,uri_alias,{{resourceId}}';

        return [
            ID::make()->sortable(),

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

            BelongsTo::make('Test Subject', 'subject'),

            Number::make('Time (minutes)', 'time')
                ->placeholder('')
                ->creationRules([])//todo
                ->sortable(),

            Select::make('Method of grading', 'mark_evaluator_type')
                ->options(
                    [
                        'default' => 'Default',
                        'custom'  => 'Custom',
                    ]
                )->default('default'),

            NovaDependencyContainer::make(
                [
                    Repeater::make('Grade table')
                        ->initialRows(1)
                        ->addField(
                            [
                                'label'      => 'Mark',
                                'name'       => 'mark',
                                'type'       => 'number',
                                'attributes' => [
                                    'required' => 'required',
                                ],
                            ]
                        )
                        ->addField(
                            [
                                'label'      => 'Percentage',
                                'name'       => 'percent',
                                'type'       => 'number',
                                'attributes' => [
                                    'step'     => 0.01,
                                    'required' => 'required',
                                ],
                            ]
                        )->resolveUsing(
                            function () {
                                $marksPercents = optional($this->resource)->marksPercents
                                    ?? Collection::make();

                                return $marksPercents->toJson();
                            }
                        )->fillUsing(
                            function ($request, $model, $attribute, $requestAttribute) {
                                $table = collect(json_decode($request->{$requestAttribute}, true));

                                $table = Collection::make(
                                    $table->map(
                                        function ($attrs) {
                                            return new MarkPercent($attrs);
                                        }
                                    )
                                );

                                resolve(GradingTableService::class)->attachForTest($model, $table);
                            }
                        ),
                ]
            )->dependsOn('mark_evaluator_type', 'custom'),

            Number::make('Results Count', 'test_results_count')
                ->exceptOnForms()
                ->readonly(),

            new Tabs(
                'Relationships',
                [
                    HasMany::make('Questions', 'nativeQuestions', Question::class),

                    HasMany::make('Test Results', 'testResults'),
                ]
            ),

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
        return [
            new Filters\SubjectsFilter('test_subject_id'),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [
        ];
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