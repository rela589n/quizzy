<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseTestSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_test_subject', function (Blueprint $table) {

            $table->unsignedBigInteger('course_id');

            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('test_subject_id');

            $table->foreign('test_subject_id')
                ->references('id')
                ->on('test_subjects')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['course_id', 'test_subject_id'], 'course_test_subject_course_id_test_subject_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_test_subject');
    }
}
