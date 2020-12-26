<?php

declare(strict_types=1);

namespace App\Nova;

use App\Models\TestResult as TestResultModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

final class TestResult extends Resource
{
    public static $model = TestResultModel::class;
    public static $perPageViaRelationship = 50;

    public static $title = 'id';

    public static $search = [
        'id'
    ];

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

            DateTime::make('Time', 'created_at')
                ->sortable(),

            Number::make('Score', 'score_readable')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Number::make('Result', 'mark_readable')
                ->hideWhenCreating()
                ->hideWhenUpdating(),
        ];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [

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
