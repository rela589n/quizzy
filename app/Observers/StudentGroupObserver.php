<?php

namespace App\Observers;

use App\Models\StudentGroup;
use Exception;

class StudentGroupObserver
{
    /**
     * Handle the User "deleted" event.
     *
     * @param  StudentGroup  $group
     * @return void
     * @throws Exception
     */
    public function deleted(StudentGroup $group): void
    {
        $group->students()->delete();
        $group->classMonitor()->delete();
    }
}
