<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formats', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->unsignedInteger('state');
            $table->unsignedInteger('municipality');
            $table->string('client');
            $table->string('main_contact');
            $table->string('position'); //puesto
            $table->string('phone');
            $table->string('email');
            $table->string('structure'); //tipo de edificio
            $table->string('environment');
            $table->unsignedInteger('has_educational_programs');
            $table->unsignedInteger('children')->nullable();
            $table->unsignedInteger('classrooms')->nullable();
            $table->unsignedInteger('state'); // !
            $table->unsignedInteger('municipality'); // !
            $table->string('colony');
            $table->string('street');
            $table->unsignedInteger('users');
            $table->unsignedInteger('has_water_lack');
            $table->string('frequency')->nullable();
            $table->string('obtaining_water');
            $table->decimal('water_consumption'); // lt, m3
            $table->decimal('cost_average');
            $table->string('water quality');
            $table->unsignedInteger('roof_type');
            $table->decimal('rainwater_area');
            $table->unsignedInteger('property_type');
            $table->unsignedInteger('current_year_resources');
            $table->unsignedInteger('resources_type')->nullable();
            $table->foreign('planning_entity_id')->references('id')->on('entities'); // nombre, puesto, correo, teléfono
            $table->foreign('auth_entity_id')->references('id')->on('entities');
            $table->date('implementation_date');
            $table->string('notes')->nullable();
            $table->foreign('project_id')->references('id')->on('projects');
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
        Schema::dropIfExists('formats');
    }
}
