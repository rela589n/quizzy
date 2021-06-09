<?php

declare(strict_types=1);

namespace App\Lib\Tests\Exceptions;

use JetBrains\PhpStorm\Immutable;
use RuntimeException;
use Throwable;

#[Immutable]
final class TestImportError extends RuntimeException
{
    public function __construct(Throwable $previous = null, $message = "", $code = 0)
    {
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }
}
