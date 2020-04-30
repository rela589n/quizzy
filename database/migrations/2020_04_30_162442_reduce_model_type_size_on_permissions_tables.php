<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReduceModelTypeSizeOnPermissionsTables extends Migration
{
    protected $tableNames;

    public function __construct()
    {
        $this->tableNames = config('permission.table_names');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableNames['model_has_permissions'], function (Blueprint $table) {
            $table->string('model_type', 96)
                ->change();
        });

        Schema::table($this->tableNames['model_has_roles'], function (Blueprint $table) {
            $table->string('model_type', 96)
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
        Schema::table($this->tableNames['model_has_permissions'], function (Blueprint $table) {
            $table->string('model_type')
                ->change();
        });

        Schema::table($this->tableNames['model_has_roles'], function (Blueprint $table) {
            $table->string('model_type')
                ->change();
        });
    }
}
