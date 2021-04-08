<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class NotNullableDepartmentIdOnStudentGroupsTable extends Migration
{
    public function up()
    {
        Schema::table(
            'student_groups',
            function (Blueprint $table) {
                $table->unsignedBigInteger('department_id')
                    ->nullable(false)
                    ->change();
            }
        );
    }

    public function down()
    {
        Schema::table(
            'student_groups',
            function (Blueprint $table) {
                $table->unsignedBigInteger('department_id')
                    ->nullable(true)
                    ->change();
            }
        );
    }
}
