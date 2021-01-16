<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Rela589n\NovaDateTimeFilter\NovaDateTimeFilter;

class FromTimestampFilter extends NovaDateTimeFilter
{
    private string $label;

    public function __construct(string $column, string $label = 'From Timestamp Filter')
    {
        parent::__construct($column);

        $this->label = $label;
    }

    public function name()
    {
        return $this->label;
    }

    /**
     * Apply the filter to the given query.
     *
     * @param  Request  $request
     * @param  EloquentBuilder  $query
     * @param  mixed  $value
     * @return EloquentBuilder
     */
    public function apply(Request $request, $query, $value)
    {
        $value = Carbon::parse($value);

        return $query->where($this->column, '>=', $value);
    }
}
