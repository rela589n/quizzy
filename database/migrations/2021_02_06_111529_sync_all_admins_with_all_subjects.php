<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

final class SyncAllAdminsWithAllSubjects extends Migration
{
    public function up()
    {
        /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Administrator[] $admins */
        $admins = \App\Models\Administrator::query()->ofRoles('teacher')->get();
        $subjectIds = \App\Models\TestSubject::query()->pluck('id');

        $admins->map(
            fn(\App\Models\Administrator $administrator) => $administrator->testSubjects()->sync($subjectIds)
        );
    }

    public function down()
    {

    }
}
