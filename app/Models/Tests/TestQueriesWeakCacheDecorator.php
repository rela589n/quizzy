<?php

declare(strict_types=1);


namespace App\Models\Tests;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Database\Eloquent\Collection;

final class TestQueriesWeakCacheDecorator implements TestQueries
{
    private TestQueries $queries;
    private Cache $cache;

    public function __construct(TestQueries $queries, Cache $cache)
    {
        $this->queries = $queries;
        $this->cache = $cache;
    }

    public function subjectsWithTestsToAttachQuestions(): Collection
    {
        return $this->cache->remember(
            __METHOD__,
            10,
            function () {
                return $this->queries->subjectsWithTestsToAttachQuestions();
            }
        );
    }
}
