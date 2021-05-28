<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLiteraturesFieldToQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(
            'questions',
            function (Blueprint $table) {
                $table->jsonb('literatures');
            }
        );

        \Illuminate\Support\Facades\DB::table('questions')
            ->update(['literatures' => []]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table(
            'questions',
            function (Blueprint $table) {
                $table->dropColumn('literatures');
            }
        );
    }
}
