<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByFieldOnTestsTable extends Migration
{
    private $table = 'tests';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')
                ->nullable()
                ->after('id');

            $table->foreign('created_by')
                ->references('id')
                ->on('administrators')
                ->onDelete('set null')
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
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropForeign(['created_by']);
        });
    }
}
