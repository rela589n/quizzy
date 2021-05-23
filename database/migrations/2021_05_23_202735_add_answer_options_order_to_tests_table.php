<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnswerOptionsOrderToTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(
            'tests',
            function (Blueprint $table) {
                $table->string('answer_options_order')
                      ->default('random');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table(
            'tests',
            function (Blueprint $table) {
                $table->dropColumn('answer_options_order');
            }
        );
    }
}
