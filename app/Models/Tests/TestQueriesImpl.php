<?php

declare(strict_types=1);


namespace App\Models\Tests;

use App\Models\Administrator;
use App\Models\Test;
use App\Models\TestSubject;
use Illuminate\Database\Eloquent\Collection;

final class TestQueriesImpl implements TestQueries
{
    public function subjectsWithTestsToAttachQuestions(Administrator $administrator): Collection
    {
        return TestSubject::query()
            ->availableForAdmin($administrator)
            ->with(
                'tests',
                function ($query) use ($administrator) {
                    /** @var TestEloquentBuilder $query */
                    return $query->availableForAdmin($administrator)->where('type', Test::TYPE_COMPOSED);
                }
            )
            ->get()
            ->filter(fn(TestSubject $subject) => $subject->tests->isNotEmpty());
    }
}
