<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateDisponibilidadFuncionarioView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('
            CREATE OR REPLACE VIEW corposalud.disponibilidad_funcionario AS 
             SELECT personas.nombres, personas.apellidos, personas.cedula, 
                disponibilidades.monto_disponible AS monto_otorgado, 
                sum(
                    CASE
                        WHEN facturas.edo_factura = 0 THEN facturas.total
                        ELSE 0::double precision
                    END) AS a_pagar, 
                disponibilidades.monto_disponible - sum(
                    CASE
                        WHEN facturas.edo_factura <> 0 THEN facturas.total
                        ELSE 0::double precision
                    END) AS monto_disponible
               FROM general.personas personas
               JOIN corposalud.beneficiarios beneficiarios ON personas.id = beneficiarios.persona_id
               JOIN corposalud.disponibilidades disponibilidades ON beneficiarios.disponibilidad_id = disponibilidades.id
               JOIN corposalud.facturas facturas ON beneficiarios.id = facturas.beneficiario_id
              GROUP BY personas.nombres, personas.cedula, disponibilidades.monto_disponible, personas.apellidos;
        ');   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP VIEW corposalud.disponibilidad_funcionario');
    }
}
