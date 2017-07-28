<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleFacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corposalud.detalles_facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('factura_id')->unsigned();
            $table->text('descripcion_gasto');
            $table->tinyInteger('edo_reg')->default(1);
            $table->float('costo');
            $table->integer('iva');

            $table->foreign('factura_id')->references('id')
            ->on('corposalud.facturas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('corposalud.detalles_facturas');
    }
}
