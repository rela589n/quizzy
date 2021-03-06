<?php


namespace App\Lib\TestResults;


use App\Exceptions\NullPointerException;
use App\Models\Test;

class CustomMarkEvaluator implements MarkEvaluator
{
    protected const UNBOUND_MARK = 2;

    protected ?Test $test = null;
    protected array $markPercentsMap;

    private MarkPercentsMapCreator $markPercentsMapCreator;

    public function __construct(MarkPercentsMapCreator $markPercentsMap)
    {
        $this->markPercentsMapCreator = $markPercentsMap;
    }

    public function setTest(Test $test): self
    {
        if ($this->test !== $test) {
            $this->markPercentsMap = $this->markPercentsMapCreator
                ->setModels($test->marksPercents)
                ->getMap();

            $this->test = $test;
        }

        return $this;
    }

    /**
     * @inheritDoc
     * @throws NullPointerException
     */
    public function putMark(?float $fullTestScore): ?int
    {
        if (null === $fullTestScore) {
            return null;
        }

        if ($this->test === null) {
            throw new NullPointerException('To evaluate test mark, respectively need test to be set.');
        }

        foreach ($this->markPercentsMap as $mark => $percents) {
            if ($fullTestScore >= ($percents - self::MARK_EPS)) {
                return $mark;
            }
        }

        return self::UNBOUND_MARK;
    }

    public function minPossibleMark(): int
    {
        return array_key_last($this->markPercentsMap);
    }

    public function maxPossibleMark(): int
    {
        return array_key_first($this->markPercentsMap);
    }

    public function leastPercentForMark(int $mark): float
    {
        foreach ($this->markPercentsMap as $possibleMark => $requiredPercents) {
            if ($possibleMark >= $mark) {
                return $requiredPercents;
            }
        }

        throw new \InvalidArgumentException(
            "Invalid mark: $mark. It must be between {$this->minPossibleMark()} and {$this->maxPossibleMark()}"
        );
    }
}
