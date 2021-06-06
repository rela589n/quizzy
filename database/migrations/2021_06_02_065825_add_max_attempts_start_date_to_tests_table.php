<?php

use App\Models\Test;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaxAttemptsStartDateToTestsTable extends Migration
{
    public function up(): void
    {
        Schema::table(
            'tests',
            function (Blueprint $table) {
                $table->timestampTz('max_attempts_start_date')
                    ->nullable();
            }
        );

        Test::query()
            ->whereNotNull('attempts_per_user')
            ->where('attempts_per_user', '>', 0)
            ->update(['max_attempts_start_date' => now()->subDays(3)]);
    }

    public function down(): void
    {
        Schema::table(
            'tests',
            function (Blueprint $table) {
                $table->dropColumn('max_attempts_start_date');
            }
        );
    }
}
