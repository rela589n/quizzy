<?php


namespace App\Lib\TestResults;


class StrictMarkEvaluator implements MarkEvaluator
{
    private const MARK_EPS = 0.09;

    public const MIN_MARK = 2;
    public const MAX_MARK = 5;

    private const LEAST_PERCENTS = [
        self::MIN_MARK => 0,
        3              => 60,
        4              => 75,
        self::MAX_MARK => 95,
    ];

    /**
     * @inheritDoc
     */
    public function putMark(?float $fullTestScore): ?int
    {
        if (null === $fullTestScore) {
            return null;
        }

        if ($fullTestScore + self::MARK_EPS < 60) {
            return self::MIN_MARK;
        }

        if ($fullTestScore + self::MARK_EPS < 75) {
            return 3;
        }

        if ($fullTestScore + self::MARK_EPS < 95) {
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

    public function leastPercentForMark(int $mark): float
    {
        return self::LEAST_PERCENTS[$mark];
    }
}
