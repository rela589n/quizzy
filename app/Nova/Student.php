<?php

namespace App\Nova;

use App\Models\User;
use App\Nova\Filters\StudentGroupsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;

class Student extends Resource
{
    public static $group = 'Студенти';

    public static int $groupPriority = 12;

    protected static bool $redirectToParentOnCreate = true;
    protected static bool $redirectToParentOnUpdate = true;

    public static $model = \App\Models\User::class;

    public static $with = ['studentGroup'];

    public static $title = 'full_name';

    public static $search = [
        'id',
        'name',
        'email',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Ім\'я', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Фамілія', 'surname')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('По-батькові', 'patronymic')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Пароль', 'password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            BelongsTo::make('Група', 'studentGroup', StudentGroup::class)->nullable(),
        ];
    }

    public static function label(): string
    {
        return 'Студенти';
    }

    public static function singularLabel()
    {
        return 'Студент';
    }

    public static function createButtonLabel()
    {
        return 'Зареєструвати студента';
    }

    public static function updateButtonLabel()
    {
        return 'Оновити';
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [
            new StudentGroupsFilter(function ($query, array $groupIds) {
                /** @var Builder|Relation|User $query */

                $query->whereIn('student_group_id', $groupIds);
            }),
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
