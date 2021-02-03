<?php

declare(strict_types=1);


namespace App\Models\Tests;

use App\Models\Query\CustomEloquentBuilder;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\User;

/** @mixin Test */
final class TestEloquentBuilder extends CustomEloquentBuilder
{
    public function withUserResultsCount(User $user)
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
}
