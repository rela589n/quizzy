<?php

namespace App\Nova\Actions;

use App\Lib\Statements\GroupStatementsGenerator;
use App\Models\TestResult;
use App\Models\TestResults\TestResultQueryBuilder;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\ActionRequest;

class DownloadTestResultsGroupReport extends Action
{
    use InteractsWithQueue, Queueable;

    public $standalone = true;

    public $onlyOnIndex = true;

    public $name = 'Звіт по групі згідно фільтрів';

    private ActionRequest $request;

    private GroupStatementsGenerator $generator;

    public function __construct()
    {
        $this->generator = new_(GroupStatementsGenerator::class);
    }

    public function handleRequest(ActionRequest $request)
    {
        $this->request = $request;
        return parent::handleRequest($request);
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @return mixed
     */
    public function handle(ActionFields $fields)
    {
        /** @var TestResultQueryBuilder $query */
        $query = $this->request->toQuery();

        $models = $query->lastResultsByEachUser()
            ->with('user')
            ->get();

        if ($models->isEmpty()) {
            return Action::danger('Не знайдено жодного результата для генерації відомості');
        }

        $groupsCount = $models->pluck('user.student_group_id')->unique()->count();

        if (1 !== $groupsCount) {
            return Action::danger('Виберіть будь ласка на фільтрі лише одну групу');
        }

        $testsCount = $models->pluck('test.id')->unique()->count();

        if (1 !== $testsCount) {
            return Action::danger(
                'Відомість по групі може бути згенерована лише для конкретного теста. Зараз обрано тестів: '.$testsCount
            );
        }

        $pathGenerator = $this->generator->getFilePathGenerator();
        $result = $this->doPerformAction($models);

        $url = $pathGenerator->url($result);
        $name = $pathGenerator->generateFileName();

        return Action::download($url, $name);
    }


    /**
     * @param  Collection|TestResult[]  $models
     *
     * @return string
     */
    private function doPerformAction(Collection $models): string
    {
        $this->generator->setTest($models[0]->test);
        $this->generator->setGroup($models[0]->user->studentGroup);
        $this->generator->setTestResults($models);

        return $this->generator->generate();
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
