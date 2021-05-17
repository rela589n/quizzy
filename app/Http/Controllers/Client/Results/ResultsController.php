<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client\Results;

use App\Factories\MarkEvaluatorsFactory;
use App\Http\Requests\Client\FilterTestResultsRequest;
use App\Lib\Filters\Eloquent\ResultFilters\Factory\ResultFiltersFactory;
use App\Lib\TestResults\ComposedMarkEvaluator;
use App\Models\User;
use App\Services\TestResults\SimpleMarksCollector;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class ResultsController
{
    public function index(FilterTestResultsRequest $request, MarkEvaluatorsFactory $factory)
    {
        /** @var User $user */
        $user = Auth::guard('client')
                    ->user();

        $evaluators = $user->passedTests()
                           ->get()->map([$factory, 'resolve'])
                           ->toArray();

        $evaluator = new ComposedMarkEvaluator($evaluators);
        $factory = new ResultFiltersFactory($evaluator);

        $filter = $factory->makeFromClientRequest($request);

        $filteredResults = $user
            ->testResults()
            ->orderByDesc('id')
            ->applyQueryFilter($filter)
            ->with('test.subject')
            ->withResultPercents()
            ->paginate(20)
            ->appends($request->query());

        $marksCollector = new SimpleMarksCollector($evaluator);

        return view(
            'pages.client.results.index',
            [
                'testResults' => $filteredResults,
                'possibleMarks' => $marksCollector->collect(),
            ],
        );
    }
}
