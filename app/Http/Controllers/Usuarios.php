<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\User;

class Usuarios extends Controller
{
	private $modulo = "usuarios";
	private $usuario;
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->usuario = Auth::user();
    }

    public function index()
    {
    	return $this->check_permiso();
    }


    private function check_permiso()
    {
    	$p_user = $this->usuario->permisos;

    	foreach ($p_user as $permiso) {
    		if( ($this->modulo == $permiso->modulo->nombre_modulo) && 
    			"Crear" == $permiso->permiso->nombre_permiso) echo "Eliminar";
			#echo $permiso->permiso->nombre_permiso."<br>";
			#
			#echo $permiso->modulo->nombre_modulo." ".$this->modulo."<br>";
    	}
    }
}
