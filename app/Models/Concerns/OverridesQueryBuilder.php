<?php

declare(strict_types=1);


namespace App\Models\Concerns;

use App\Models\Query\CustomBuilder;
use Illuminate\Database\Eloquent\Model;

/** @mixin Model */
trait OverridesQueryBuilder
{
    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();
        $grammar = $connection->getQueryGrammar();
        $processor = $connection->getPostProcessor();

        return new CustomBuilder($connection, $grammar, $processor);
    }
}
