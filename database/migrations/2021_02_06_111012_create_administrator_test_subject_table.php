<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateAdministratorTestSubjectTable extends Migration
{
    public function up(): void
    {
        Schema::create(
            'administrator_test_subject',
            function (Blueprint $table) {
                $table->unsignedBigInteger('administrator_id');

                $table->foreign('administrator_id')
                    ->references('id')
                    ->on('administrators')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

                $table->unsignedBigInteger('test_subject_id');

                $table->foreign('test_subject_id')
                    ->references('id')
                    ->on('test_subjects')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

                $table->primary(
                    ['administrator_id', 'test_subject_id'],
                    'administrator_test_subject_primary',
                );

                $table->engine = 'InnoDB';

                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('administrator_test_subject');
    }
}
