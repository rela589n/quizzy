<?php


namespace App\Lib\TestResults;


class StrictMarkEvaluator implements MarkEvaluatorInterface
{
    /**
     * @inheritDoc
     */
    public function putMark(float $fullTestScore): int
    {
        return max(1, (int)round($fullTestScore * 5 - 0.1));
    }
}
