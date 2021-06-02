<?php

declare(strict_types=1);

namespace App\Models\Tests;

use App\Models\Administrator;
use App\Models\Query\CustomBuilder;
use App\Models\Query\CustomEloquentBuilder;
use App\Models\Subjects\SubjectEloquentBuilder;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\User;

/** @mixin Test */
final class TestEloquentBuilder extends CustomEloquentBuilder
{
    /** @var Test */
    protected $model;

    public function withUserResultsCount(User $user): self
    {
        return $this->withCount(
            [
                'testResults as user_results_count' => fn($q) => $this->userResultsCountSub($user, $q),
            ]
        );
    }

    public function whereUserResultsCountLessThanAllowedAttempts(User $user): self
    {
        return $this->where(
            function ($query) use ($user) {
                /** @var CustomBuilder $query */
                return $query->whereNull('tests.attempts_per_user')
                    ->orWhereHas(
                        'testResults',
                        fn($q) => $this->userResultsCountSub($user, $q),
                        '<',
                        $this->raw('tests.attempts_per_user'),
                    );
            }
        );
    }

    private function userResultsCountSub(User $user, $query)
    {
        /** @var TestResult $query */
        return $query->where('user_id', $user->id)
            ->where('created_at', '>=', $this->raw('tests.max_attempts_start_date'));
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
