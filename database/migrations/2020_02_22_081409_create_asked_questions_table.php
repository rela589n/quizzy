<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAskedQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asked_questions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('test_result_id');
            $table->foreign('test_result_id')
                ->references('id')
                ->on('test_results')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asked_questions');
    }
}
