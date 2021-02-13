<?php

namespace App\Nova\Actions;

use App\Lib\Statements\StudentStatementsGenerator;
use App\Models\TestResult;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Webmozart\Assert\Assert;

class DownloadTestResultReport extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Завантажити звіт';

    public $onlyOnDetail = true;

    private StudentStatementsGenerator $service;

    public function __construct()
    {
        $this->service = new_(StudentStatementsGenerator::class);
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        Assert::count($models, 1);
        Assert::isInstanceOf($models->first(), TestResult::class);

        /** @var TestResult $result */
        $result = $models->first();
        $this->service->setResult($result);
        $path = $this->service->generate();

        $pathGenerator = $this->service->getFilePathGenerator();
        $url = $pathGenerator->url($path);

        return Action::download($url, $pathGenerator->generateFileName());
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
