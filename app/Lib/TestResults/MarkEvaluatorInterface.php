<?php


namespace App\Lib\TestResults;


interface MarkEvaluatorInterface
{
    /**
     * @param float $fullTestScore score between [0 and 1]
     * @return int corresponding mark
     */
    public function putMark(float $fullTestScore) : int;
}
