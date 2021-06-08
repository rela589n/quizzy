<?php

declare(strict_types=1);

namespace App\Lib\TestResults;

use App\Exceptions\IncompatibleMarkEvaluationStrategies;
use InvalidArgumentException;
use JetBrains\PhpStorm\Immutable;
use LogicException;
use Webmozart\Assert\Assert;

use function array_map;
use function array_unique;

#[Immutable]
final class ComposedMarkEvaluator implements MarkEvaluator
{
    private array $evaluators;

    public function __construct(array $evaluators)
    {
        $this->evaluators = array_map(static fn(MarkEvaluator $evaluator) => $evaluator, $evaluators);
    }

    public function putMark(?float $fullTestScore): ?int
    {
        throw new LogicException(__METHOD__.' can\'t be implemented');
    }

    public function minPossibleMark(): ?int
    {
        if (empty($this->evaluators)) {
            return null;
        }

        return min(array_map(static fn(MarkEvaluator $evaluator) => $evaluator->minPossibleMark(), $this->evaluators));
    }

    public function maxPossibleMark(): ?int
    {
        if (empty($this->evaluators)) {
            return null;
        }

        return max(array_map(static fn(MarkEvaluator $evaluator) => $evaluator->maxPossibleMark(), $this->evaluators));
    }

    public function leastPercentForMark(int $mark): float
    {
        $leastPercents = array_map(static fn(MarkEvaluator $evaluator) => $evaluator->leastPercentForMark($mark), $this->evaluators);
        $uniquePercents = array_unique($leastPercents);

        try {
            Assert::count($uniquePercents, 1);
        } catch (InvalidArgumentException $e) {
            throw new IncompatibleMarkEvaluationStrategies();
        }

        return end($uniquePercents);
    }
}
