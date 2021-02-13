<?php

namespace App\Nova\Filters;

use App\Models\StudentGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class StudentGroupsFilter extends BooleanFilter
{
    public $name = 'Фільтр Груп';

    private \Closure $queryBuilder;

    private $initialQuery;

    public function __construct(\Closure $queryBuilder, $initialQuery = null)
    {
        $this->queryBuilder = $queryBuilder;
        $this->initialQuery = $initialQuery ?? StudentGroup::query();
    }

    /**
     * Apply the filter to the given query.
     *
     * @param  Request  $request
     * @param  Builder  $query
     * @param  mixed  $value
     * @return Builder
     */
    public function apply(Request $request, $query, $value)
    {
        $groupIds = array_keys(array_filter($value));

        return empty($groupIds)
            ? $query
            : ($this->queryBuilder)($query, $groupIds);
    }

    /**
     * Get the filter's available options.
     *
     * @param  Request  $request
     * @return array
     */
    public function options(Request $request): array
    {
        return $this->initialQuery
            ->availableForAdmin($request->user())
            ->orderByDesc('name')
            ->get(['name', 'id'])
            ->flatMap(
                fn(StudentGroup $g) => [$g->name => $g->id]
            )->toArray();
    }
}
