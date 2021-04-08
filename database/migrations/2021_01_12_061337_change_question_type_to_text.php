<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class ChangeQuestionTypeToText extends Migration
{
    public function up()
    {
        Schema::table(
            'questions',
            function (Blueprint $table) {
                $table->text('question')
                    ->change();
            }
        );
    }

    public function down()
    {
        Schema::table(
            'questions',
            function (Blueprint $table) {
                $table->string('question', 255)
                    ->change();
            }
        );
    }
}
