<?php

namespace App\Observers;

use App\Models\StudentGroup;

class StudentGroupObserver
{
    /**
     * Handle the User "deleted" event.
     *
     * @param StudentGroup $group
     * @return void
     */
    public function deleted(StudentGroup $group)
    {
        $group->students()->delete();
        $group->classMonitor()->delete();
    }
}
