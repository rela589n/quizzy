<?php

namespace App\Nova;

use App\Nova\Actions\AttachTestsQuestionsToTest;
use App\Nova\Actions\ExportTestIntoFile;
use App\Nova\Actions\ImportTestFromFile;
use App\Nova\Fields\Custom\Test\AdditionalQuestionsRelationField;
use App\Nova\Fields\Custom\Test\GradingStrategyField;
use App\Nova\Fields\Custom\Test\GradingTableField;
use App\Nova\Fields\Custom\Test\NameField;
use App\Nova\Fields\Custom\Test\NameStackReadOnly;
use App\Nova\Fields\Custom\Test\PassTimeField;
use App\Nova\Fields\Custom\Test\ResultsCountReadOnly;
use App\Nova\Fields\Custom\Test\TestSubjectField;
use App\Nova\Fields\Custom\Test\TestTypeField;
use App\Nova\Fields\Custom\Test\UriAliasField;
use App\Rules\Containers\TestRulesContainer;
use Eminiarts\Tabs\Tabs;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

class Test extends Resource
{
    public static $group = 'Тестування';

    public static int $groupPriority = 2;

    public static $model = \App\Models\Test::class;

    /** @var \App\Models\Test */
    public $resource;

    public static $title = 'name';

    public static $preventFormAbandonment = true;

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

    public function fields(Request $request)
    {
        $creationRules = $this->rulesContainer->getRules();
        $updateRules = $this->rulesContainer->getRules();

        $creationRules['uri_alias'][] = 'unique:tests,uri_alias';
        $updateRules['uri_alias'][] = 'unique:tests,uri_alias,{{resourceId}}';

        return [
            ID::make()->sortable(),

            TestSubjectField::make(),

            NameStackReadOnly::make(),

            NameField::make(),

            UriAliasField::make(),

            TestTypeField::make(),

            GradingStrategyField::make(),

            AdditionalQuestionsRelationField::make(),

            NovaDependencyContainer::make([GradingTableField::make()])
                ->dependsOn('mark_evaluator_type', 'custom'),

            PassTimeField::make(),

            ResultsCountReadOnly::make(),

            new Tabs(
                'Relationships',
                [
                    HasMany::make('Запитання', 'nativeQuestions', Question::class),

                    HasMany::make('Результати проходження', 'testResults', TestResult::class)
                        ->singularLabel('проходження'),
                ]
            ),

        ];
    }

    public static function label()
    {
        return 'Тести';
    }

    public static function singularLabel()
    {
        return 'Тест';
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [
            new Filters\SubjectsFilter('test_subject_id'),
        ];
    }

    public function lenses(Request $request)
    {
        return [
        ];
    }

    public function actions(Request $request)
    {
        return [
            (new AttachTestsQuestionsToTest())->onlyOnIndex(),
            (new ExportTestIntoFile())->onlyOnTableRow()->showOnDetail(),
            (new ImportTestFromFile())->onlyOnDetail(),
        ];
    }
}
