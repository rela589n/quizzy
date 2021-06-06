<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRestrictExtraneousActivityFieldToTestsTable extends Migration
{
    public function up(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->boolean('restrict_extraneous_activity')
                  ->default(1);
        });
    }

    public function down(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->removeColumn('restrict_extraneous_activity');
        });
    }
}
