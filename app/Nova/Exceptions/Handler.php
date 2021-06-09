<?php

declare(strict_types=1);

namespace App\Nova\Exceptions;

use App\Lib\Tests\Exceptions\TestImportError;
use JetBrains\PhpStorm\Immutable;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Exceptions\NovaExceptionHandler;
use Throwable;

use function app;

#[Immutable]
final class Handler extends NovaExceptionHandler
{
    /**
     * Report or log an exception.
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        return parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TestImportError) {
            return response()->json(Action::danger('Помилка імпорту: ' . $exception->getPrevious()->getMessage()));
        }

        return parent::render($request, $exception);
    }
}
