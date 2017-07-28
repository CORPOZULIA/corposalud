<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general.estatus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_estatus', 150);
            $table->string('tipo_status', 150);
            $table->text('des_estatus');

            $table->tinyInteger('edo_reg')->default(1);
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
        Schema::drop('general.estatus');
    }
}
