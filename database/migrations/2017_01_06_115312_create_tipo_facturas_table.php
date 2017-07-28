<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corposalud.tipo_facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('codigo_factura', 3);
            $table->text('descripcion_factura');
            $table->tinyInteger('edo_reg')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('corposalud.tipo_facturas');
    }
}
