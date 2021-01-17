<?php


namespace App\Lib\TestResults;


interface MarkEvaluator
{
    public const MARK_EPS = 0.09;

    /**
     * @param float $fullTestScore score between [0 and 1]
     * @return int corresponding mark
     */
    public function putMark(float $fullTestScore): int;

    public function minPossibleMark(): int;

    public function maxPossibleMark(): int;

    public function leastPercentForMark(int $mark): float;
}
