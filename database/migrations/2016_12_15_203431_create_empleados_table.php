<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general.empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->dateTime('fecha_inactividad')->nullable();
            $table->tinyInteger('edo_reg')->default(1);

            $table->integer('persona_id')->unsigned();
            $table->foreign('persona_id')
                    ->references('id')
                    ->on('general.personas')
                    ->onDelate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('general.empleados');
    }
}
