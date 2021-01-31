<?php

declare(strict_types=1);


namespace App\Models\Tests;

use App\Models\Test;
use App\Models\TestSubject;
use Illuminate\Database\Eloquent\Collection;

final class TestQueriesImpl implements TestQueries
{
    public function subjectsWithTestsToAttachQuestions(): Collection
    {
        return TestSubject::query()
            ->with('tests', fn($query) => $query->where('type', Test::TYPE_COMPOSED))
            ->get();
    }
}
