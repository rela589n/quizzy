<?php

declare(strict_types=1);

namespace App\Nova;

use App\Models\TestResult as TestResultModel;
use App\Nova\Filters\StudentGroupsFilter;
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
     * @param  Builder|TestResultModel  $query
     * @return Builder|void
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->with(
            [
                'test',
                'askedQuestions.question',
                'askedQuestions.answers.answerOption',
                'user.studentGroup',
            ]
        );
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

            Number::make('Score, %', 'score_readable')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Number::make('Mark', 'mark_readable')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make('Time', 'created_at')
                ->sortable(),
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
            )
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
}
