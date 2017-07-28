<?php

namespace App\Http\Controllers\Modulos\corposalud;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class Familia extends Controller
{
    public function formulario(Request $request, $formulario)
    {
    	$formulario = Storage::disk('local')->get('formularios/corposalud/'.$formulario.'.html');
    	$retorno = [
    		'fail' => false,
    		'mensaje' => $formulario
    	];

    	return $retorno;
    }
}
