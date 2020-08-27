<?php


namespace App\Lib\TestResults;


interface MarkEvaluator
{
    /**
     * @param float $fullTestScore score between [0 and 1]
     * @return int corresponding mark
     */
    public function putMark(float $fullTestScore): int;

    public function minPossibleMark(): int;

    public function maxPossibleMark(): int;
}
