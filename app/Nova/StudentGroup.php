<?php

namespace App\Nova;

use App\Models\StudentGroups\StudentGroupEloquentBuilder;
use App\Repositories\AdministratorsRepository;
use App\Rules\Containers\Group\GroupNameRules;
use App\Rules\Containers\Group\GroupUriSlugRules;
use App\Rules\Containers\Group\GroupYearRules;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

use function app;

class StudentGroup extends Resource
{
    public static $group = 'Студенти';

    public static int $groupPriority = 8;

    public static $model = \App\Models\StudentGroup::class;

    /** @var \App\Models\StudentGroup */
    public $resource;

    public static $title = 'name';

    public static $search = [
        'id',
        'name',
        'uri_alias',
    ];

    /**
     * @param  NovaRequest  $request
     * @param  StudentGroupEloquentBuilder  $query
     * @return Builder
     */
    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        return $query
            ->with('department')
            ->withCount('students')
            ->availableForAdmin($request->user());
    }

    /**
     * @param  NovaRequest  $request
     * @param  StudentGroupEloquentBuilder  $query
     * @return Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return $query->withCount('students')
            ->with('classMonitor');
    }

    /**
     * @param  NovaRequest  $request
     * @param  StudentGroupEloquentBuilder  $query
     * @return Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return $query->availableForAdmin($request->user());
    }

    public function fields(Request $request)
    {
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
                ->creationRules(GroupYearRules::forCreate())
                ->updateRules(GroupYearRules::forUpdate())
                ->sortable(),

            Text::make('Назва', 'name')
                ->creationRules(GroupNameRules::forCreate())
                ->updateRules(GroupNameRules::forUpdate())
                ->hideFromIndex()
                ->hideFromDetail(),

            Slug::make('Uri-псевдонім', 'uri_alias')
                ->from('name')
                ->creationRules(GroupUriSlugRules::forCreate())
                ->updateRules(GroupUriSlugRules::forUpdate())
                ->hideFromIndex()
                ->hideFromDetail(),

            BelongsTo::make('Відділення', 'department', Department::class)
                ->required(),

            Text::make('Староста', 'classMonitor')
                ->resolveUsing([$this, 'resolveClassMonitor'])
                ->onlyOnDetail(),

            HasMany::make('Студенти', 'students', Student::class),
        ];
    }

    public function fieldsForUpdate(NovaRequest $request)
    {
        $adminRepo = app(AdministratorsRepository::class);

        $classMonitors = $adminRepo->probableClassMonitors($this->resource)
            ->keyBy('id')
            ->map([$this, 'formatClassMonitor']);

        return [
            ...$this->fields($request),

            Select::make('Староста', 'classMonitor')
                ->resolveUsing(static fn($admin) => $admin->id ?? null)
                ->fillUsing(fn($req, $model, $attr, $reqAttr) => $model->created_by = $req->$reqAttr)
                ->options($classMonitors)
                ->onlyOnForms(),
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

    public function resolveClassMonitor(): ?string
    {
        if (null === $this->resource->classMonitor) {
            return null;
        }

        return $this->formatClassMonitor($this->resource->classMonitor);
    }

    public function formatClassMonitorResource(Administrator $classMonitor)
    {
        return $this->formatClassMonitor($classMonitor->resource);
    }

    public function formatClassMonitor(\App\Models\Administrator $classMonitor): string
    {
        return "{$classMonitor->full_name} ({$classMonitor->id})";
    }
}
