<?php

namespace App\Nova\Actions;

use App\Lib\Statements\TestsExportManager;
use Illuminate\Bus\Queueable;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class ExportTestIntoFile extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Експорт';

    private TestsExportManager $exportManager;

    public function __construct()
    {
        $this->exportManager = resolve(TestsExportManager::class);
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
        if ($models->count() !== 1) {
            throw new \InvalidArgumentException('Models must contain exactly one value');
        }

        $test = $models->first();

        $this->exportManager->setTest($test);
        $exportedPath = $this->exportManager->generate();
        $pathGenerator = $this->exportManager->getFilePathGenerator();
        $pathGenerator->url($exportedPath);

        return Action::download($pathGenerator->url($exportedPath), $pathGenerator->generateFileName());
    }
}
