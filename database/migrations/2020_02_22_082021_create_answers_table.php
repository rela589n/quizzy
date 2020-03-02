<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('answer_option_id');
            $table->foreign('answer_option_id')
                ->references('id')
                ->on('answer_options')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('asked_question_id');
            $table->foreign('asked_question_id')
                ->references('id')
                ->on('asked_questions')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->tinyInteger('is_chosen')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
