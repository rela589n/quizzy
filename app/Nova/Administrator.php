<?php

declare(strict_types=1);

namespace App\Nova;

use App\Models\Administrator as AdministratorModel;
use App\Models\Administrators\AdministratorsEloquentBuilder;
use App\Nova\Fields\Custom\Administrator\RoleField;
use Benjacho\BelongsToManyField\BelongsToManyField;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

final class Administrator extends Resource
{
    public static $model = AdministratorModel::class;

    public static $title = 'surname';

    public static $search = [
        'id',
        'name',
        'surname',
        'patronymic',
        'email',
    ];

    /**
     * @param  NovaRequest  $request
     * @param  AdministratorsEloquentBuilder  $query
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('surname', '!=', 'system')
            ->with('roles')
            ->with('departments')
            ->with('testSubjects')
            ->availableToViewBy($request->user());
    }

    public function fields(Request $request)
    {
        $showcallback = fn() => $request->user()->id !== $this->resource->id;

        return [
            ID::make(),

            Text::make('Ім\'я', 'name')
                ->rules('required'),

            Text::make('Прізвище', 'surname')
                ->rules('required'),

            Text::make('По батькові', 'patronymic')
                ->rules('required'),

            Text::make(__('Email'), 'email')
                ->rules('required', 'email', 'max:254'),

            Password::make('Пароль', 'password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8')
                ->showOnUpdating($showcallback),

            RoleField::make($request->user())
                ->showOnUpdating($showcallback),

            BelongsToManyField::make('Відділення', 'departments', Department::class)
                ->showOnUpdating($showcallback),

            BelongsToManyField::make('Предмети', 'testSubjects', TestSubject::class)
                ->showOnUpdating($showcallback),

            Boolean::make('Змінено пароль', 'password_changed')
                ->exceptOnForms(),
        ];
    }

    public static function createButtonLabel()
    {
        return 'Зареєструвати '.self::singularLabel().'а';
    }

    public static function singularLabel()
    {
        return 'Адміністратор';
    }

    public static function label()
    {
        return 'Адміністратори';
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [];
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
