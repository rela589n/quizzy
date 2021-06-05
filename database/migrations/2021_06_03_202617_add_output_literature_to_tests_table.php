<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOutputLiteratureToTestsTable extends Migration
{
    public function up(): void
    {
        Schema::table(
            'tests',
            function (Blueprint $table) {
                $table->boolean('output_literature')
                    ->default(true);
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'tests',
            function (Blueprint $table) {
                $table->dropColumn('output_literature');
            }
        );
    }
}
