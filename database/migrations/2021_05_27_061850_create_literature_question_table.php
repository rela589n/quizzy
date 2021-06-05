<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** @deprecated */
class CreateLiteratureQuestionTable extends Migration
{
    public function up(): void
    {
        Schema::create(
            'literature_question',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('literature_id')
                    ->references('id')
                    ->on('literatures')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();

                $table->foreignId('question_id')
                    ->references('id')
                    ->on('questions')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('literature_question');
    }
}
