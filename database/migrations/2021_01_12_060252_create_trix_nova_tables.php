<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateTrixNovaTables extends Migration
{
    public function up()
    {
        Schema::create('nova_pending_trix_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('draft_id', 175)->index();
            $table->string('attachment');
            $table->string('disk');
            $table->timestamps();
        });

        Schema::create('nova_trix_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attachable_type', 150);
            $table->unsignedInteger('attachable_id');
            $table->string('attachment');
            $table->string('disk');
            $table->string('url', 175)->index();
            $table->timestamps();

            $table->index(['attachable_type', 'attachable_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('nova_trix_attachments');
        Schema::dropIfExists('nova_pending_trix_attachments');
    }
}
