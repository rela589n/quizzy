<?php


namespace App\Factories;


use App\Exceptions\UnknownMarkEvaluatorTypeException;
use App\Lib\TestResults\CustomMarkEvaluator;
use App\Lib\TestResults\MarkEvaluator;
use App\Lib\TestResults\StrictMarkEvaluator;
use App\Models\Test;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Foundation\Application;

class MarkEvaluatorsFactory
{
    private ApplicationContract $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    private ?Test $test = null;

    /**
     * @param  Test  $test
     * @return $this
     */
    public function setTest(Test $test): self
    {
        $this->test = $test;

        return $this;
    }

    /**
     * @param  string|null  $type
     *
     * @return MarkEvaluator
     */
    public function resolve(string $type = null): MarkEvaluator
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
                throw new UnknownMarkEvaluatorTypeException('Could not find mark evaluator for "'.$type.'" type.');
        }
    }
}
