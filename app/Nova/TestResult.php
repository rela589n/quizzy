<?php

declare(strict_types=1);

namespace App\Nova;

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
     * @param  TestResultQueryBuilder|TestResultModel  $query
     * @return Builder|void
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

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Test', 'test', Test::class),

            BelongsTo::make('User', 'user', Student::class)
                ->sortable(),

            Fields\BelongsTo::make('Group', 'user.studentGroup', StudentGroup::class)
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Number::make('Score, %', 'result_percents')
                ->sortable(),

            Number::make('Mark', 'result_mark'),

            DateTime::make('Час проходження', 'created_at')
                ->sortable()
                ->format('DD.MM.YYYY HH:mm:ss'),
        ];
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
                }
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
