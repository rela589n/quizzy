<?php

namespace App\Nova;

use App\Models\Tests\TestEloquentBuilder;
use App\Nova\Actions\AttachTestsQuestionsToTest;
use App\Nova\Actions\ExportTestIntoFile;
use App\Nova\Actions\ImportTestFromFile;
use App\Nova\Fields\Custom\Test\AdditionalQuestionsRelationField;
use App\Nova\Fields\Custom\Test\AttemptsPerUserField;
use App\Nova\Fields\Custom\Test\GradingStrategyField;
use App\Nova\Fields\Custom\Test\GradingTableField;
use App\Nova\Fields\Custom\Test\NameField;
use App\Nova\Fields\Custom\Test\NameStackReadOnly;
use App\Nova\Fields\Custom\Test\PassTimeField;
use App\Nova\Fields\Custom\Test\QuestionsOrderField;
use App\Nova\Fields\Custom\Test\ResultsCountReadOnly;
use App\Nova\Fields\Custom\Test\TestDisplayStrategyField;
use App\Nova\Fields\Custom\Test\TestSubjectField;
use App\Nova\Fields\Custom\Test\TestTypeField;
use App\Nova\Fields\Custom\Test\UriAliasField;
use Eminiarts\Tabs\Tabs;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Database\Eloquent\Builder;
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

    public static $perPageViaRelationship = 25;

    public static $search = [
        'id',
        'name',
    ];

    /**
     * @param  NovaRequest  $request
     * @param  TestEloquentBuilder  $query
     * @return Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withCount('testResults')
            ->with('subject')
            ->with('marksPercents')
            ->with('nativeQuestions.answerOptions')
            ->availableForAdmin($request->user());
    }

    /**
     * @param  NovaRequest  $request
     * @param  TestEloquentBuilder  $query
     * @return Builder
     */
    public static function detailQuery(NovaRequest $request, $query): Builder
    {
        return $query->withCount('testResults')
            ->with('subject');
    }

    public function fields(Request $request)
    {
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

            TestDisplayStrategyField::make(),

            QuestionsOrderField::make(),

            AttemptsPerUserField::make(),

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

    public function cards(Request $request): array
    {
        return [];
    }

    public function filters(Request $request): array
    {
        return [
            new Filters\SubjectsFilter('test_subject_id'),
        ];
    }

    public function lenses(Request $request): array
    {
        return [
        ];
    }

    public function actions(Request $request): array
    {
        return [
            (new AttachTestsQuestionsToTest())->onlyOnIndex(),
            (new ExportTestIntoFile())->onlyOnTableRow()->showOnDetail(),
            (new ImportTestFromFile())->onlyOnDetail(),
        ];
    }
}
