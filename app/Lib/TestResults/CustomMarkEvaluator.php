<?php


namespace App\Lib\TestResults;


use App\Exceptions\NullPointerException;
use App\Models\Test;

class CustomMarkEvaluator implements MarkEvaluator
{
    const MARK_EPS = 0.09;
    protected const UNBOUND_MARK = 2;

    /**
     * @var Test
     */
    protected $test;

    /**
     * @var array
     */
    protected $markPercentsMap;

    /**
     * @param Test $test
     * @return CustomMarkEvaluator
     */
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
     * @var MarkPercentsMapCreator
     */
    private $markPercentsMapCreator;

    public function __construct(MarkPercentsMapCreator $markPercentsMap)
    {
        $this->markPercentsMapCreator = $markPercentsMap;
    }

    /**
     * @inheritDoc
     * @throws NullPointerException
     */
    public function putMark(float $fullTestScore): int
    {
        $fullTestScore *= 100;

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
}
