<?php

declare(strict_types=1);

namespace App\Exceptions;

use JetBrains\PhpStorm\Immutable;
use RuntimeException;

#[Immutable]
final class IncompatibleMarkEvaluationStrategies extends RuntimeException
{

}
