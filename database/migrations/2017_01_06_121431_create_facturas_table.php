<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corposalud.facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->float('total')->default(0.00);
            $table->date('fecha_factura')->nullable();
            $table->tinyInteger('edo_reg')->default(1);

            $table->integer('tipo_factura_id')->unsigned();
            $table->integer('beneficiario_id')->unsigned();
            $table->integer('edo_factura')->default(0);
            $table->string('numero_factura', 14)->default('000000');

            $table->foreign('tipo_factura_id')->references('id')
                    ->on('corposalud.tipo_facturas')->onDelete('CASCADE');

            $table->foreign('beneficiario_id')->references('id')
                    ->on('corposalud.beneficiarios')->onDelete('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('corposalud.facturas');
    }
}
