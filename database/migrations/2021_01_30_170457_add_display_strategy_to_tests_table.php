<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AddDisplayStrategyToTestsTable extends Migration
{
    public function up()
    {
        Schema::table(
            'tests',
            function (Blueprint $table) {
                $table->string('display_strategy', 100)
                    ->default(\App\Models\Test::DISPLAY_ALL);
            }
        );
    }

    public function down()
    {
        Schema::table(
            'tests',
            function (Blueprint $table) {
                $table->dropColumn('display_strategy');
            }
        );
    }
}
