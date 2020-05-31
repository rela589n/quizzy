<?php


namespace App\Factories;


use App\Exceptions\UnknownMarkEvaluatorTypeException;
use App\Lib\TestResults\CustomMarkEvaluator;
use App\Lib\TestResults\MarkEvaluator;
use App\Lib\TestResults\StrictMarkEvaluator;
use App\Models\Test;
use Illuminate\Foundation\Application;

class MarkEvaluatorsFactory
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application
     */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @var Test
     */
    private $test;

    /**
     * @param Test $test
     * @return MarkEvaluatorsFactory
     */
    public function setTest(Test $test): self
    {
        $this->test = $test;

        return $this;
    }

    /**
     * @param string|null $type
     * @return MarkEvaluator
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function resolve(string $type = null) : MarkEvaluator
    {
        if ($type === null) {
            $type = $this->test->mark_evaluator_type;
        }

        switch ($type) {
            case 'default':
                return $this->app->make(StrictMarkEvaluator::class);

            case 'custom':
                $markEvaluator = $this->app->make(CustomMarkEvaluator::class);
                $markEvaluator->setTest($this->test);

                return $markEvaluator;

            default:
                throw new UnknownMarkEvaluatorTypeException('Could not find mark evaluator for "' . $type . '" type.');
        }
    }
}
