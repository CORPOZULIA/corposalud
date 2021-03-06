<?php

namespace App\Http\Controllers\Modulos\corposalud;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Persona;

use App\Http\Controllers\Modulos\corposalud\Models\Beneficiario;

class ActualizarBeneficiarios extends Controller
{
    
    public function actualizar()
    {
    	$personas = Persona::where('edo_reg', 1)->get();
    	$i = 0;
    	foreach ($personas as $persona) 
    	{
    		$persona->beneficiario()->save( new Beneficiario( ['disponibilidad_id' => 1] ) );
    		$i++;
    	}

    	print "Se ha actualizado la tabla de beneficiarios con ".$i." registros";
    	return 0;
    }
}
