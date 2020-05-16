<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToIsRightFieldOnAnswerOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answer_options', function (Blueprint $table) {
            $table->boolean('is_right')
                ->default(false)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answer_options', function (Blueprint $table) {
            $table->smallInteger('is_right')
                ->tinyInteger('is_right')
                ->default(NULL)
                ->change();
        });
    }
}
