<?php


namespace App\Lib\TestResults;


class StrictMarkEvaluator implements MarkEvaluator
{
    private const MARK_EPS = 0.09;

    public const MIN_MARK = 2;
    public const MAX_MARK = 5;

    /**
     * @inheritDoc
     */
    public function putMark(float $fullTestScore): int
    {
        $fullTestScore *= 100;
        $fullTestScore += self::MARK_EPS;

        if ($fullTestScore < 60) {
            return self::MIN_MARK;
        }

        if ($fullTestScore < 75) {
            return 3;
        }

        if ($fullTestScore < 95) {
            return 4;
        }

        return self::MAX_MARK;
    }

    public function minPossibleMark(): int
    {
        return self::MIN_MARK;
    }

    public function maxPossibleMark(): int
    {
        return self::MAX_MARK;
    }
}
