<?php


namespace App\Factories;

use App\Exceptions\UnknownMarkEvaluatorTypeException;
use App\Lib\TestResults\CustomMarkEvaluator;
use App\Lib\TestResults\MarkEvaluator;
use App\Lib\TestResults\StrictMarkEvaluator;
use App\Models\Test;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Foundation\Application;

class MarkEvaluatorsFactory
{
    private ApplicationContract $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function resolve(Test $test): MarkEvaluator
    {
        switch ($test->mark_evaluator_type) {
            case 'default':
                return $this->app->make(StrictMarkEvaluator::class);

            case 'custom':
                $markEvaluator = $this->app->make(CustomMarkEvaluator::class);
                $markEvaluator->setTest($test);

                return $markEvaluator;

            default:
                throw new UnknownMarkEvaluatorTypeException('Could not find mark evaluator for "'.$test->mark_evaluator_type.'" type.');
        }
    }
}
