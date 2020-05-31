<?php


namespace App\Services\TestResults;


use App\Factories\MarkEvaluatorsFactory;
use App\Lib\TestResults\MarkEvaluator;
use App\Models\Test;

class MarksCollector
{
    /**
     * @var MarkEvaluatorsFactory
     */
    protected $markEvaluatorsFactory;

    public function __construct(MarkEvaluatorsFactory $markEvaluatorsFactory)
    {
        $this->markEvaluatorsFactory = $markEvaluatorsFactory;
    }

    /**
     * @var Test
     */
    protected $test;

    /**
     * @param Test $test
     * @return MarksCollector
     */
    public function setTest(Test $test): self
    {
        $this->test = $test;

        return $this;
    }

    /**
     * @var MarkEvaluator
     */
    protected $markEvaluator;

    /**
     * @return MarkEvaluator
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function markEvaluator(): MarkEvaluator
    {
        if ($this->markEvaluator === null) {
            $this->markEvaluator = $this->markEvaluatorsFactory->setTest($this->test)->resolve();
        }

        return $this->markEvaluator;
    }

    /**
     * @return \Generator|array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function collect()
    {
        foreach (range($this->markEvaluator()->minPossibleMark(), $this->markEvaluator()->maxPossibleMark()) as $item) {
            yield $item;
        }
    }
}
