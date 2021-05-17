<?php

declare(strict_types=1);

namespace App\Lib\Filters\Eloquent\ResultFilters;

use App\Lib\TestResults\MarkEvaluator;
use App\Models\TestResults\TestResultQueryBuilder;
use JetBrains\PhpStorm\Immutable;
use LogicException;

#[Immutable]
final class ResultMarkRangeFilter implements QueryFilter
{
    private int $fromMark;
    private int $toMark;

    private MarkEvaluator $markEvaluator;

    public function __construct(MarkEvaluator $markEvaluator, int $fromMark, int $toMark)
    {
        $this->markEvaluator = $markEvaluator;
        $this->fromMark = $fromMark;
        $this->toMark = $toMark;
    }

    public function apply(TestResultQueryBuilder $builder): void
    {
        $shouldRestrictFromLeft = $this->markEvaluator->minPossibleMark() !== $this->fromMark;
        $shouldRestrictFromRight = $this->markEvaluator->maxPossibleMark() !== $this->toMark;

        if (!$shouldRestrictFromLeft
            && !$shouldRestrictFromRight) {
            return;
        }

        if ($shouldRestrictFromLeft && $shouldRestrictFromRight) {
            $builder->whereMarkPercentBetween(
                $this->markEvaluator->leastPercentForMark($this->fromMark),
                $this->markEvaluator->leastPercentForMark(1 + $this->toMark) - MarkEvaluator::MARK_EPS,
            );

            return;
        }

        if ($shouldRestrictFromLeft) {
            $builder->whereMarkPercentAtLeast(
                $this->markEvaluator->leastPercentForMark($this->fromMark),
            );

            return;
        }

        if ($shouldRestrictFromRight) {
            $builder->whereMarkPercentAtMost(
                $this->markEvaluator->leastPercentForMark(1 + $this->toMark) - MarkEvaluator::MARK_EPS,
            );

            return;
        }

        throw new LogicException('Should not get here');
    }
}
