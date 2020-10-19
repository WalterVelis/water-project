<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formats', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('planning_entity_id')->references('id')->on('entities'); // nombre, puesto, correo, teléfono
            $table->foreign('auth_entity_id')->references('id')->on('entities');
            // $table->foreign('created_by')->references('id')->on('users');
            // $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
