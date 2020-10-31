<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tech_formats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page')->unique();
            $table->date('date');
            $table->string('client');
            $table->string('city');
            $table->string('main_contact');
            $table->string('position'); //puesto
            $table->string('phone');
            $table->string('email');
            $table->string('structure');
            $table->string('water_quality');
            $table->string('filter_type');
            $table->string('roof_type');
            $table->string('obtaining_water');
            $table->string('rooftop');
            $table->string('rainwater_area');
            $table->string('anual_precipitation');
            $table->string('storage_volume');
            $table->string('water_tank');
            $table->string('distance');
            $table->string('cleanliness');
            $table->string('roof_slope');

            $table->float('excavation');
            $table->unsignedInteger('filter_stall');
            $table->unsignedInteger('subnotes');
            $table->unsignedInteger('has_pump_room');
            $table->unsignedInteger('flood_risk');
            $table->unsignedInteger('d_float');
            $table->unsignedInteger('require_connection');
            $table->unsignedInteger('control');
            $table->unsignedInteger('electro');
            $table->string('notes');
            $table->unsignedInteger('format_id');
            $table->foreign('format_id')->references('id')->on('formats');
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
        Schema::dropIfExists('tech_formats');
    }
}
