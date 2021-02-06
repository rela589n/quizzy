<?php

namespace App\Nova;

use App\Models\Subjects\SubjectEloquentBuilder;
use App\Rules\Containers\SubjectRulesContainer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use ZiffMedia\NovaSelectPlus\SelectPlus;

class TestSubject extends Resource
{
    public static $group = 'Тестування';

    public static int $groupPriority = 1;

    public static $model = \App\Models\TestSubject::class;

    public static $title = 'name';

    public static $search = [
        'id',
        'name',
        'uri_alias',
    ];

    private SubjectRulesContainer $rulesContainer;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->rulesContainer = app(SubjectRulesContainer::class);
    }

    /**
     * @param  NovaRequest  $request
     * @param  SubjectEloquentBuilder  $query
     *
     * @return Builder
     */
    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        return $query->with(['departments', 'courses'])
            ->availableForAdmin($request->user());
    }

    public function fields(Request $request)
    {
        $creationRules = $this->rulesContainer->getRules();
        $updateRules = $this->rulesContainer->getRules();

        $creationRules['uri_alias'][] = 'unique:test_subjects,uri_alias';
        $updateRules['uri_alias'][] = 'unique:test_subjects,uri_alias,{{resourceId}}';

        return [
            ID::make(__('ID'), 'id')->sortable(),
            Stack::make(
                'Назва',
                [
                    Line::make('Name')->asHeading(),
                    Line::make('Slug', 'uri_alias')->asSmall(),
                ]
            )->sortable(),

            Text::make('Назва', 'name')
                ->creationRules($creationRules['name'])
                ->updateRules($updateRules['name'])
                ->hideFromDetail()
                ->hideFromIndex(),

            Slug::make('Uri-псевдонім', 'uri_alias')
                ->from('name')
                ->creationRules($creationRules['uri_alias'])
                ->updateRules($updateRules['uri_alias'])
                ->hideFromDetail()
                ->hideFromIndex(),

            SelectPlus::make('Відділення', 'departments', Department::class)
                ->usingDetailLabel('name')
                ->hideFromIndex(),

            SelectPlus::make('Курс(и)', 'courses', Course::class)
                ->label('public_name')
                ->usingDetailLabel('public_name')
                ->usingIndexLabel('public_name'),

            HasMany::make('Тести', 'tests', Test::class),
        ];
    }

    public static function label()
    {
        return 'Предмети тестування';
    }

    public static function singularLabel()
    {
        return 'Предмет тестування';
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
