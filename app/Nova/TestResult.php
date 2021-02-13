<?php

declare(strict_types=1);

namespace App\Nova;

use App\Models\StudentGroup as StudentGroupModel;
use App\Models\StudentGroups\StudentGroupEloquentBuilder;
use App\Models\Students\StudentEloquentBuilder;
use App\Models\TestResult as TestResultModel;
use App\Models\TestResults\TestResultQueryBuilder;
use App\Nova\Filters\FromTimestampFilter;
use App\Nova\Filters\StudentGroupsFilter;
use App\Nova\Filters\TestResultMarksFilter;
use App\Nova\Filters\ToTimestampFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

final class TestResult extends Resource
{
    public static $model = TestResultModel::class;
    public static $perPageViaRelationship = 40;

    public static $title = 'id';

    public static $search = [
        'id'
    ];

    /** @var TestResultModel */
    public $resource;

    /**
     * @param  NovaRequest  $request
     * @param  TestResultQueryBuilder  $query
     *
     * @return Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->with(
            [
                'test',
                'user.studentGroup',
            ]
        )->withResultPercents();
    }

    /**
     * @param  NovaRequest  $request
     * @param  TestResultQueryBuilder  $query
     *
     * @return Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return $query->with(
            [
                'test',
                'user.studentGroup',
            ]
        )->withResultPercents();
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Тест', 'test', Test::class),

            BelongsTo::make('Студент', 'user', Student::class)
                ->sortable(),

            Fields\BelongsTo::make('Група', 'user.studentGroup', StudentGroup::class)
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Number::make('Результат %', 'result_percents')
                ->sortable(),

            Number::make('Оцінка', 'result_mark'),

            DateTime::make('Час проходження', 'created_at')
                ->sortable()
                ->format('DD.MM.YYYY HH:mm:ss'),

            HasMany::make('Задані питання', 'askedQuestions', AskedQuestion::class),
        ];
    }

    public static function label()
    {
        return 'Результати проходження';
    }

    public static function singularLabel()
    {
        return 'Проходження';
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request): array
    {
        return [
            new StudentGroupsFilter(
                function ($query, array $groupIds) {
                    /** @var Builder|Relation|TestResultModel $query */

                    return $query->whereHas(
                        'user',
                        fn($userQuery) => $userQuery->whereIn('student_group_id', $groupIds)
                    );
                },
                StudentGroupModel::query()
                    ->when(
                        'tests' === $request->get('viaResource'),
                        fn(StudentGroupEloquentBuilder $query) => $query->whereHas(
                            'students',
                            function ($studentQuery) use ($request) {
                                /** @var StudentEloquentBuilder $studentQuery */
                                return $studentQuery->whereHas(
                                    'testResults',
                                    function ($testResultsQuery) use ($request) {
                                        /** @var TestResultQueryBuilder $testResultsQuery */
                                        $testResultsQuery->where('test_id', $request->get('viaResourceId'));
                                    },
                                );
                            },
                        ),
                    ),
            ),
            new FromTimestampFilter('created_at', 'Дата від'),
            new ToTimestampFilter('created_at', 'Дата до'),
            ...$this->additionalFilters($request),
        ];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [];
    }

    private function additionalFilters(Request $request): array
    {
        $additional = [];

        if ($request->get('viaResource') === 'tests') {
            $additional[] = new TestResultMarksFilter((int)$request->get('viaResourceId'));
        }

        return $additional;
    }
}
