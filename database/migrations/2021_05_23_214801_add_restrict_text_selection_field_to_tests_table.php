<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRestrictTextSelectionFieldToTestsTable extends Migration
{
    public function up(): void
    {
        Schema::table(
            'tests',
            function (Blueprint $table) {
                $table->boolean('restrict_text_selection')
                      ->default(true);
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'tests',
            function (Blueprint $table) {
                $table->dropColumn('restrict_text_selection');
            }
        );
    }
}
