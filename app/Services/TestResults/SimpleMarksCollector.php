<?php

declare(strict_types=1);

namespace App\Services\TestResults;

use App\Lib\TestResults\MarkEvaluator;
use JetBrains\PhpStorm\Immutable;

use function range;

#[Immutable]
final class SimpleMarksCollector
{
    private MarkEvaluator $evaluator;

    public function __construct(MarkEvaluator $evaluator) { $this->evaluator = $evaluator; }

    public function collect(): array
    {
        return range($this->evaluator->minPossibleMark(), $this->evaluator->maxPossibleMark());
    }
}
