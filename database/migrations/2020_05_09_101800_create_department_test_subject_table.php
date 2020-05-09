<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentTestSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_test_subject', function (Blueprint $table) {

            $table->unsignedBigInteger('department_id');

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('test_subject_id');

            $table->foreign('test_subject_id')
                ->references('id')
                ->on('test_subjects')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['department_id', 'test_subject_id'], 'department_test_subject_department_id_test_subject_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_test_subject');
    }
}
