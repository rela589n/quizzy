<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AddTypeFieldToTestsTable extends Migration
{
    public function up()
    {
        Schema::table(
            'tests',
            function (Blueprint $table) {
                $table->string('type', 100)
                    ->default('standalone')
                    ->nullable(false)
                    ->index();
            }
        );

        \Illuminate\Support\Facades\DB::unprepared(
            <<< SQL
                UPDATE tests
                    SET type = 'composed'
                WHERE (SELECT COUNT(*) FROM test_composite WHERE test_composite.id_test = tests.id) > 1
            SQL
        );
    }

    public function down()
    {
        Schema::table(
            'tests',
            function (Blueprint $table) {
                $table->dropIndex('tests_type_index');
                $table->dropColumn('type');
            }
        );
    }
}
