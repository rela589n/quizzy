<?php

namespace App\Nova\Filters;

use App\Models\StudentGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class StudentGroupsFilter extends BooleanFilter
{
    private \Closure $queryBuilder;

    public function __construct(\Closure $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
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
        return StudentGroup::query()
            ->orderByDesc('name')
            ->get(['name', 'id'])
            ->flatMap(
                fn(StudentGroup $g) => [$g->name => $g->id]
            )->toArray();
    }
}
