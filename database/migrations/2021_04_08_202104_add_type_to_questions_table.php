<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AddTypeToQuestionsTable extends Migration
{
    public function up()
    {
        Schema::table(
            'questions',
            function (Blueprint $table) {
                $table->string('type')
                    ->default('c');
            }
        );
    }

    public function down()
    {
        Schema::table(
            'questions',
            function (Blueprint $table) {
                $table->dropColumn('type');
            }
        );
    }
}
