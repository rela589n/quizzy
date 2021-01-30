<?php

namespace App\Nova\Actions;

use App\Lib\Tests\TestImportService;
use App\Rules\Containers\Test\TestImportFileRules;
use Illuminate\Bus\Queueable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;

class ImportTestFromFile extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Імпорт';

    private TestImportService $importer;

    public function __construct()
    {
        $this->importer = resolve(TestImportService::class);
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
        /** @var UploadedFile $file */
        $file = $fields->get('file');
        $this->importer->importFile($file);
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            File::make('Файл з питаннями', 'file')
                ->rules((new TestImportFileRules())->build()),
        ];
    }
}
