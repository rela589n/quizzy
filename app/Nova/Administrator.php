<?php

declare(strict_types=1);

namespace App\Nova;

use App\Models\Administrator as AdministratorModel;
use App\Models\Administrators\AdministratorsEloquentBuilder;
use App\Nova\Fields\Custom\Administrator\RoleField;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
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
            ->availableToViewBy($request->user());
    }

    public function fields(Request $request)
    {
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
                ->updateRules('nullable', 'string', 'min:8'),

            RoleField::make(),

            Number::make('Змінено пароль', 'password_changed')
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
