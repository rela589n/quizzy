<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Test;

final class TestObserver
{
    /**
     * Handle the test "created" event.
     *
     * @param  Test  $test
     */
    public function created(Test $test)
    {
        $test->tests()->sync(
            [$test->id => ['questions_quantity' => 999]]
        );
    }

    /**
     * Handle the test "updated" event.
     *
     * @param  Test  $test
     */
    public function updated(Test $test)
    {
        //
    }

    /**
     * Handle the test "deleted" event.
     *
     * @param  Test  $test
     */
    public function deleted(Test $test)
    {
        //
    }

    /**
     * Handle the test "restored" event.
     *
     * @param  Test  $test
     */
    public function restored(Test $test)
    {
        //
    }

    /**
     * Handle the test "force deleted" event.
     *
     * @param  Test  $test
     */
    public function forceDeleted(Test $test)
    {
        //
    }
}
