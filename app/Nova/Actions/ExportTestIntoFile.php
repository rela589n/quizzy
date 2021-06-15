<?php

namespace App\Nova\Actions;

use App\Lib\Statements\TestsExportManager;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;

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
        $this->exportManager->shouldStripHtml($fields->get('strip_html'));
        $exportedPath = $this->exportManager->generate();
        $pathGenerator = $this->exportManager->getFilePathGenerator();
        $pathGenerator->url($exportedPath);

        return Action::download($pathGenerator->url($exportedPath), $pathGenerator->generateFileName());
    }

    public function fields(): array
    {
        return [
            Boolean::make('Видалення спецсимволів', 'strip_html')
                ->help(
                    'Коли ввімкнено, то результат буде згенеровано без html-символів.
                        Такий файл краще підходить для перегляду, але не підходить для подальшого імопрту з нього'
                ),
        ];
    }
}
