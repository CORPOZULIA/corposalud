<?php

/******************************************************************************
*	MODULO PRINCIPAL: CORPOZ
*	RUTA: SIGUECPZ/APP/HTTP/CONTROLLERS/INTRANET/CORPOZ.PHP
*	DESARROLLADO POR: Giovanny Avila [<gjavila1995@gmail.com>|<gavila@corpozulia.gob.ve>]
*						Julio Chirinos [<>]
*	FECHA:  30 DE DICIEMBRE DE 2016
*	
*	USO: GESTIONA TODA LA INFORMACION DE REGISTRO Y VERIFICACION DE USUARIOS DEL SISTEMA
*		Y SU RELACION CON LA BASE DE DATOS DE SIGESP MEDIANTE EL ESQUEMA GENERAL
*		
**************************************************************************************/

namespace App\Http\Controllers\intranet;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PersonaSugau;
use App\Persona;
use App\Empleado;
use App\User;
use App\ModPerUser as permisos;

use Session;

class Corpoz extends Controller
{
    /**
    *	@function  FUNCION VERIFICAR
    *	@param $cedula STRING [OBTIENE LA CEDULA A VERIFICAR]
    *	@return JSON [retorna los datos de la tabla de personal en el esquema public de SIGESP
    *					correspondientes a la cedula]
    */
    public function verificar($cedula='')
    {

    	$cedula = ($cedula=='') ? 'No aplica' : $cedula;

    	$datos_persona = PersonaSugau::getPersonasugau($cedula);

        //return dd($datos_persona);
    	if(empty($datos_persona[0]))
    	{
    		$datos_persona[0]['fail'] = true;
    		$datos_persona[0]['mensaje_error'] = 'No se ha encontrado persona con este número de cedula';
    	}
    	else
    	{
    		$datos_persona[0]->fail = false;
    	}

	    return json_encode($datos_persona);
    }

    /**
    *	funcion crear 
    *	RETORNA  UNA REDIRECCION 
    */
    public function crear(Request $Request){
    	
    #	return dd($Request->only(['codper']));
        $persona = Persona::where('codper', $Request->input('codper'))->get();

        if( empty($persona[0]))
        {
        	$persona = new Persona($Request->only(['codper']));
        	if($persona->save()){
        		if($persona->empleado()->save(new Empleado([]))){
        			
        			if($persona->empleado->user()->save(
        				new User($Request->only(['usuario', 'password']))
        			))
                    {
                        $this->permisos($persona->empleado->user);
                        return redirect()->to('/login');
                    }
        		}
        	}
        } #ENDIF
        else
        { 
            session()->flash('codper_repeat', 'Lo sentimos, usted ya posee cuenta dentro de este sistema. Si olvido su cuenta
                            favor llamar a sistemas...');


            //return "Ya usted posee un usuario en el sistema, si la olvido favor llamar a sistemas";
        }
    	return redirect()->to('/login');
    }


    private function permisos($user)
    {
       $user->permisos()->save(
            new permisos(['modulo_id'=> 5 , 'permiso_id' => 4])
        );
    }
}
