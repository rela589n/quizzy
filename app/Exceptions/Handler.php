<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
        'new_password',
        'new_password_confirmation'
    ];

    /**
     * Report or log an exception.
     * @throws \Exception
     */
    public function report(Throwable $exception): void
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof EmptyTestResultsException) {
            throw new NotFoundHttpException();
        }

        if ($exception instanceof IncompatibleMarkEvaluationStrategies) {
            return $this->render(
                $request,
                ValidationException::withMessages(
                    ['mark' => 'На разі немає змоги відфільтрувати по оцінці, адже ви проходили тести з несумісними стратегіями оцінювання.']
                )
            );
        }

        return parent::render($request, $exception);
    }
}
