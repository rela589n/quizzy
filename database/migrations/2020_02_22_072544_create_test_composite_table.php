<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestCompositeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_composite', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('id_test');
            $table->foreign('id_test')
                ->references('id')
                ->on('tests')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('id_include_test');
            $table->foreign('id_include_test')
                ->references('id')
                ->on('tests')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedSmallInteger('questions_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_composite');
    }
}
