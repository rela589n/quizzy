<?php

namespace App\Nova\Actions;

use App\Lib\Statements\TestsExportManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class ImportTestFromFile extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Імпорт';

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
        //
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
