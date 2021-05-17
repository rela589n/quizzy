<?php

declare(strict_types=1);

namespace App\Lib\Filters\Eloquent\ResultFilters\Factory;

use App\Http\Requests\Client\FilterTestResultsRequest;
use App\Lib\Filters\Eloquent\ResultFilters\Composed\AndFiltersCollection;
use App\Lib\Filters\Eloquent\ResultFilters\Composed\OrFiltersCollection;
use App\Lib\Filters\Eloquent\ResultFilters\QueryFilter;
use App\Lib\Filters\Eloquent\ResultFilters\ResultDateFilter;
use App\Lib\Filters\Eloquent\ResultFilters\ResultIdFilter;
use App\Lib\Filters\Eloquent\ResultFilters\ResultMarkFilter;
use App\Lib\Filters\Eloquent\ResultFilters\ResultPercentsFilter;
use App\Lib\Filters\Eloquent\ResultFilters\SubjectNameFilter;
use App\Lib\Filters\Eloquent\ResultFilters\TestNameFilter;
use App\Lib\TestResults\MarkEvaluator;
use Carbon\Carbon;
use InvalidArgumentException;
use JetBrains\PhpStorm\Immutable;

use function array_keys;
use function array_map;
use function array_values;

#[Immutable]
final class ResultFiltersFactory
{
    private MarkEvaluator $evaluator;

    public function __construct(MarkEvaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    public function makeFromClientRequest(FilterTestResultsRequest $request): QueryFilter
    {
        $attributes = $request->getQueryFilterAttributes();

        return new AndFiltersCollection(
            array_map(
                fn(string $name, $value) => $this->makeFromClientName($name, $value),
                array_keys($attributes),
                array_values($attributes),
            ),
        );
    }

    public function makeFromClientName(string $name, $value)
    {
        switch (true) {
            case 'resultId' === $name:
                return new ResultIdFilter($value);
            case 'subjectName' === $name:
                return new SubjectNameFilter($value);
            case 'testName' === $name:
                return new TestNameFilter($value);
            case 'result' === $name:
                return new ResultPercentsFilter((float)$value);
            case 'mark' === $name:
                return new ResultMarkFilter($this->evaluator, (int)$value);
            case 'resultDate' === $name:
                return new ResultDateFilter($value);
            case 'resultDateIn' === $name:
                return new OrFiltersCollection(
                    array_map(
                        fn(Carbon $date) => $this->makeFromClientName('resultDate', $date),
                        $value,
                    ),
                );
        }

        throw new InvalidArgumentException("Unknown '$name' attribute.");
    }
}
