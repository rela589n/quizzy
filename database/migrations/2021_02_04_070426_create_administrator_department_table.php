<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateAdministratorDepartmentTable extends Migration
{
    public function up()
    {
        Schema::create(
            'administrator_department',
            function (Blueprint $table) {
                $table->unsignedBigInteger('administrator_id');

                $table->foreign('administrator_id')
                    ->references('id')
                    ->on('administrators')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

                $table->unsignedBigInteger('department_id');

                $table->foreign('department_id')
                    ->references('id')
                    ->on('departments')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

                $table->primary(
                    ['administrator_id', 'department_id'],
                    'administrator_department_administrator_id_department_id_primary',
                );

                $table->engine = 'InnoDB';

                $table->timestamps();
            }
        );
    }

    public function down()
    {
        Schema::dropIfExists('administrator_department');
    }
}
