<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class GiveDefaultValueForQuestionsQuantityOnTestCompositeTable extends Migration
{
    public function up(): void
    {
        Schema::table(
            'test_composite',
            function (Blueprint $table) {
                $table->unsignedSmallInteger('questions_quantity')
                    ->default(999)
                    ->change();
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'test_composite',
            function (Blueprint $table) {
                $table->unsignedSmallInteger('questions_quantity')
                    ->default(null)
                    ->change();
            }
        );
    }
}
