<?php

declare(strict_types=1);


namespace App\Models\Tests;

use App\Models\Administrator;
use App\Models\Query\CustomEloquentBuilder;
use App\Models\Subjects\SubjectEloquentBuilder;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\User;

/** @mixin Test */
final class TestEloquentBuilder extends CustomEloquentBuilder
{
    public function withUserResultsCount(User $user): self
    {
        return $this->withCount(
            [
                'testResults as user_results_count' => function ($q) use ($user) {
                    /** @var TestResult $q */
                    $q->where('user_id', $user->id);
                }
            ]
        );
    }

    public function availableForAdmin(Administrator $administrator): self
    {
        if ($administrator->can('viewAll', Test::class)) {
            return $this;
        }

        return $this->whereHas(
            'subject',
            static fn(SubjectEloquentBuilder $builder) => $builder->availableForAdmin($administrator)
        )->where('created_by', $administrator->id);
    }

    public function availableToPassBy(User $user): self
    {
        return $this->whereIsPublished(true);
    }
}
