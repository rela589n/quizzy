<?php

use App\Models\Department;
use App\Models\TestSubject;
use Illuminate\Database\Seeder;

class SyncSubjectsWithDepartments extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = Department::all();

        foreach (TestSubject::all() as $subject) {
            if ($subject->departments()->exists()) {
                continue;
            }

            $subject->departments()->sync($departments);
        }
    }
}
