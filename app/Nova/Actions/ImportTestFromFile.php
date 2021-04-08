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
use Webmozart\Assert\Assert;

class ImportTestFromFile extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Імпорт';

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

        /** @var UploadedFile $file */
        $file = $fields->get('file');

        $importer = new TestImportService($models->first());

        $importer->importFile($file);
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
                ->rules(new TestImportFileRules()),
        ];
    }
}
