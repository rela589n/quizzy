<?php

namespace App\Nova;

use App\Models\MarkPercent;
use App\Nova\Actions\AttachTestsQuestionsToTest;
use App\Nova\Actions\ExportTestIntoFile;
use App\Rules\Containers\TestRulesContainer;
use App\Services\Tests\Grading\GradingTableService;
use Eminiarts\Tabs\Tabs;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Fourstacks\NovaRepeatableFields\Repeater;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Http\Requests\ResourceDetailRequest;

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
     * @param  NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder|\App\Models\Test  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return $query->withCount('testResults')
            ->with('subject');
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

            BelongsTo::make('Test Subject', 'subject')
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

            Select::make('Тип теста', 'type')
                ->displayUsingLabels()
                ->default(\App\Models\Test::TYPE_STANDALONE)
                ->options(
                    array_combine(
                        \App\Models\Test::TYPES,
                        array_map(
                            static fn($t) => __($t),
                            \App\Models\Test::TYPES
                        )
                    )
                ),

            Select::make('Method of grading', 'mark_evaluator_type')
                ->displayUsingLabels()
                ->options(
                    array_combine(
                        \App\Models\Test::EVALUATOR_TYPES,
                        array_map(
                            static fn($t) => __($t),
                            \App\Models\Test::EVALUATOR_TYPES
                        )
                    )
                )->default(\App\Models\Test::EVALUATOR_TYPE_DEFAULT)
                ->hideFromIndex(),

            BelongsToMany::make('Additional Questions', 'tests', Test::class)
                ->fields(
                    fn() => [
                        Number::make('Questions', 'questions_quantity')
                    ]
                )->showOnDetail(
                    function (ResourceDetailRequest $request) {
                        return $this->resource->type === \App\Models\Test::TYPE_COMPOSED;
                    }
                )
                ->searchable(),

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

            Number::make('Time (minutes)', 'time')
                ->placeholder('')
                ->creationRules([])//todo
                ->sortable(),

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
        return [
            (new AttachTestsQuestionsToTest())->onlyOnIndex(),
            (new ExportTestIntoFile())->onlyOnTableRow()->showOnDetail(),
        ];
    }
}
