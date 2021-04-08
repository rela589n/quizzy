<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AddAttemptsPerUserToTestsTable extends Migration
{
    public function up()
    {
        Schema::table(
            'tests',
            function (Blueprint $table) {
                $table->integer('attempts_per_user')
                    ->nullable();
            }
        );
    }

    public function down()
    {
        Schema::table(
            'tests',
            function (Blueprint $table) {
                $table->dropColumn('attempts_per_user');
            }
        );
    }
}
