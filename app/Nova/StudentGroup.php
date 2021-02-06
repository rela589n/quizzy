<?php

namespace App\Nova;

use App\Models\StudentGroups\StudentGroupEloquentBuilder;
use App\Rules\Containers\GroupRulesContainer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class StudentGroup extends Resource
{
    public static $group = 'Студенти';

    public static int $groupPriority = 8;

    public static $model = \App\Models\StudentGroup::class;

    public static $title = 'name';

    public static $search = [
        'id',
        'name',
        'uri_alias',
    ];

    private GroupRulesContainer $rulesContainer;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->rulesContainer = app(GroupRulesContainer::class);
    }

    /**
     * @param  NovaRequest  $request
     * @param  StudentGroupEloquentBuilder  $query
     * @return Builder
     */
    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        return $query
            ->with('department')
            ->availableForAdmin($request->user());
    }

    public function fields(Request $request)
    {
        $creationRules = $this->rulesContainer->creationRules();
        $updateRules = $this->rulesContainer->creationRules();///todo

        $updateRules['uri_alias'][] = 'unique:student_groups,uri_alias,{{resourceId}}';

        return [
            ID::make(__('ID'), 'id')
                ->sortable(),

            Stack::make(
                'Назва',
                [
                    Line::make('Name')->asHeading(),
                    Line::make('Slug', 'uri_alias')->asSmall(),
                ]
            )->sortable(),

            Number::make('Рік вступу', 'year')
                ->creationRules($creationRules['year'])
                ->updateRules($updateRules['year'])
                ->sortable(),

            Text::make('Назва', 'name')
                ->creationRules($creationRules['name'])
                ->updateRules($updateRules['name'])
                ->hideFromIndex()
                ->hideFromDetail(),

            Slug::make('Uri-псевдонім', 'uri_alias')
                ->from('name')
                ->creationRules($creationRules['uri_alias'])
                ->updateRules($updateRules['uri_alias'])
                ->hideFromIndex()
                ->hideFromDetail(),

            HasMany::make('Студенти', 'students', Student::class),

            BelongsTo::make('Відділення', 'department', Department::class)
                ->required(),
        ];
    }

    public static function label(): string
    {
        return 'Групи студентів';
    }

    public static function singularLabel()
    {
        return 'Група';
    }

    public static function createButtonLabel()
    {
        return 'Створити групу';
    }

    public static function updateButtonLabel()
    {
        return 'Редагувати групу';
    }

    public function cards(Request $request): array
    {
        return [];
    }

    public function filters(Request $request): array
    {
        return [];
    }

    public function lenses(Request $request): array
    {
        return [];
    }

    public function actions(Request $request): array
    {
        return [];
    }
}
