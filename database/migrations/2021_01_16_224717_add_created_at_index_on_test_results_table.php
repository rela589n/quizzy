<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AddCreatedAtIndexOnTestResultsTable extends Migration
{
    public function up()
    {
        Schema::table(
            'test_results',
            function (Blueprint $table) {
                $table->index('created_at');
            }
        );
    }

    public function down()
    {
        Schema::table(
            'test_results',
            function (Blueprint $table) {
                $table->dropIndex('test_results_created_at_index');
            }
        );
    }
}
