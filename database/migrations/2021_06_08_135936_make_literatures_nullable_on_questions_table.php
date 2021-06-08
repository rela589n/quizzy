<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeLiteraturesNullableOnQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'questions',
            function (Blueprint $table) {
                $table->json('literatures')
                    ->nullable()
                ->change();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'questions',
            function (Blueprint $table) {
                $table->jsonb('literatures')
                    ->nullable(false)
                ->change();
            }
        );
    }
}
