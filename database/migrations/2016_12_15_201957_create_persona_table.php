<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general.personas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('nombres', 250)->nullable();
            $table->string('apellidos', 250)->nullable();
            $table->string('email')->nullable();
            $table->text('direccion')->nullable();
            $table->string('cedula', 20)->nullable();
            $table->string('telefono_personal')->nullable();
            $table->string('telefono_habitacion')->nullable();
            $table->tinyInteger('edo_reg')->default(1);
            $table->string('codper')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('general.personas');
    }
}
