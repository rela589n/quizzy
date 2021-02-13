<?php

namespace App\Nova\Filters;

use App\Models\Test;
use App\Models\TestSubject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class SubjectsFilter extends Filter
{
    public $name = 'Фільтр по Предметам';

    private string $field;

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * Apply the filter to the given query.
     *
     * @param  Request  $request
     * @param  Builder|Test  $query
     * @param  mixed  $value
     * @return Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where($this->field, $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return TestSubject::query()
            ->availableForAdmin($request->user())
            ->get(['name', 'id'])
            ->mapWithKeys(fn(TestSubject $subject) => [$subject->name => $subject->id])
            ->toArray();
    }
}
