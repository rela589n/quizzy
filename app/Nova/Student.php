<?php

namespace App\Nova;

use App\Models\Students\StudentEloquentBuilder;
use App\Models\User;
use App\Nova\Actions\PromoteStudentToClassMonitor;
use App\Nova\Filters\StudentGroupsFilter;
use App\Repositories\StudentGroupsRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Student extends Resource
{
    public static $group = 'Студенти';

    public static int $groupPriority = 12;

    protected static bool $redirectToParentOnCreate = true;
    protected static bool $redirectToParentOnUpdate = true;

    public static $perPageViaRelationship = 40;

    public static $model = User::class;

    /** @var User */
    public $resource;

    public static $with = ['studentGroup'];

    public static $title = 'full_name';

    public static $search = [
        'id',
        'name',
        'email',
    ];

    protected static array $defaultOrderings = [
        'surname'    => 'asc',
        'name'       => 'asc',
        'patronymic' => 'asc',
    ];

    /**
     * @param  NovaRequest  $request
     * @param  StudentEloquentBuilder  $query
     * @return Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->with('studentGroup.department')
            ->availableForAdmin($request->user());
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Фамілія', 'surname')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Ім\'я', 'name')
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
            new StudentGroupsFilter(
                function ($query, array $groupIds) {
                    /** @var Builder|Relation|User $query */

                    $query->whereIn('student_group_id', $groupIds);
                }
            ),
        ];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        /** @var NovaRequest $request */

        if (($request->viaRelationship() &&
                $request->viaResource() === StudentGroup::class)
            || Str::of($request->header('referer'))
                ->contains('student-groups')) {
            return [
                new PromoteStudentToClassMonitor(
                    app()->make(StudentGroupsRepository::class)
                        ->findById((int)$request->get('viaResourceId'))
                ),
            ];
        }

        return [];
    }
}
