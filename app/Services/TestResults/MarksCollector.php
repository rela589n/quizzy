<?php


namespace App\Services\TestResults;


use App\Factories\MarkEvaluatorsFactory;
use App\Lib\TestResults\MarkEvaluator;
use App\Models\Test;
use Generator;
use Illuminate\Contracts\Container\BindingResolutionException;

class MarksCollector
{
    protected MarkEvaluatorsFactory $markEvaluatorsFactory;

    public function __construct(MarkEvaluatorsFactory $markEvaluatorsFactory)
    {
        $this->markEvaluatorsFactory = $markEvaluatorsFactory;
    }

    protected Test $test;

    /**
     * @param  Test  $test
     * @return $this
     */
    public function setTest(Test $test): self
    {
        $this->test = $test;

        return $this;
    }

    protected ?MarkEvaluator $markEvaluator = null;

    /**
     * @return MarkEvaluator
     * @throws BindingResolutionException
     */
    public function markEvaluator(): MarkEvaluator
    {
        if ($this->markEvaluator === null) {
            $this->markEvaluator = $this->markEvaluatorsFactory->resolve($this->test);
        }

        return $this->markEvaluator;
    }

    /**
     * @return Generator|array
     * @throws BindingResolutionException
     */
    public function collect()
    {
        foreach (range($this->markEvaluator()->minPossibleMark(), $this->markEvaluator()->maxPossibleMark()) as $item) {
            yield $item;
        }
    }
}
