<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qty');
            $table->float('unit_cost');
            $table->unsignedInteger('material_id');
            $table->unsignedInteger('provider_id');
            $table->foreign('material_id')->references('id')->on('materials');
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials_providers');
    }
}
