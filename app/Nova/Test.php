<?php

namespace App\Nova;

use App\Models\Tests\TestEloquentBuilder;
use App\Nova\Actions\AttachTestsQuestionsToTest;
use App\Nova\Actions\ExportTestIntoFile;
use App\Nova\Actions\ImportTestFromFile;
use App\Nova\Fields\Custom\Test\AdditionalQuestionsRelationField;
use App\Nova\Fields\Custom\Test\AnswerOptionsOrderField;
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
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

use function get_class;

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

            Boolean::make('Виведення літератури', 'output_literature')
                ->help('Після проходження теста, студенту буде виведено заданий викладачем перелік літератури до питань, на які студент дав некоректну відповідь')
                ->hideFromIndex()
                ->hideWhenCreating(),

            Panel::make('Представлення', [
                TestDisplayStrategyField::make(),

                QuestionsOrderField::make(),

                AnswerOptionsOrderField::make(),
            ]),

            Panel::make('Обмеження', [
                Boolean::make('Доступний для проходження', 'is_published')
                    ->help('Чи можуть студенти зараз проходити цей тест')
                    ->withMeta(['value' => $this->resource->is_published ?? true])
                    ->hideFromIndex(),

                PassTimeField::make(),

                AttemptsPerUserField::make(),

                NovaDependencyContainer::make(
                    [
                        DateTime::make('Дата відліку обмеження спроб', 'max_attempts_start_date')
                            ->rules(['required_with:attempts_per_user'])
                            ->help('Спроби будуть обмежені починаючи цією датою (всі проходження до дати не обмежуються)')
                    ]
                )->dependsOnNotEmpty('attempts_per_user')
                    ->hideFromIndex(),

                Boolean::make('Обмеження сторонньої активності', 'restrict_extraneous_activity')
                    ->help('Коли ввімкнено, студенти зобов\'язані залишатись в поточному вікні браузера')
                    ->hideFromIndex(),

                Boolean::make('Обмеження виділення тексту', 'restrict_text_selection')
                    ->help('Коли ввімкнено, студенти не зможуть виділяти текст питань та відповідей')
                    ->hideFromIndex(),
            ]),

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

    protected static function fillFields(NovaRequest $request, $model, $fields)
    {
        /** @var \App\Models\Test $model */
        $result = parent::fillFields($request, $model, $fields);

        if (!$model instanceof \App\Models\Test) {
            return $result;
        }

        if (empty($request->get('attempts_per_user'))) {
            $model->max_attempts_start_date = null;
        }

        return $result;
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
