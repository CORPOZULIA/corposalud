<?php
/*************************************************************************
 *				CONTROLADOR PRINCIPAL DE LAS CUENTAS
 *				DE LOS USUARIOS (AQUÍ INGRESAN LOS USUARIOS CUANDO SE LOGEAN)
 *				PROGRAMADO EL DIA 21 DE DICIEMBRE
 * 
 ****************************************************************************/
namespace App\Http\Controllers\intranet;

use Illuminate\Http\Request;



use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use App\Persona;
use App\Empleado;
use App\User;
use App\Permiso;
use App\ModPerUser;
use Session;

class Dashboard extends Controller
{
	#ESTA PROPIEDAD ALMACENA LOS MODULOS DISPONIBLES PARA EL USUARIO
	#QUE SE ENCUENTRA CONECTADO EN EL MOMENTO
	private $mods;             #LA VARIABLE $mods CONTIENE LOS MODULOS Y PERMISOS HABILITADOS PARA LOS USUARIOS
    private $controlador;       #LA VARIABLE $controlador CONTIENE EL VERDADERO CONTROLADOR QUE SE BUSCA (ES LA PRIMERA PARTE
                                    #DEL DE LA URL LUEGO DE DASHBOARD)
    private $accion;             #LA VARIABLE $accion POSEE EL MOTODO A LLAMAR DENTRO DEL CONTROLADOR

	public function __construct()
	{
		#RETORNA TODOS LOS MODULOS A LOS QUE EL USUARIO TIENE PERMISO
		#DE INGRESAR
    	$this->mods = ModPerUser::getModulos(Auth::user()->id);
	}

    public function index()
    {
    	return view('intranet.dashboard', ['modulos' => $this->mods]);
    }

    public function modulo(Request $request, $modulo, $programa='', $accion='', $id='')
    {
        $accion = ( $accion == '' ) ? env('DEFAULT_ACCION', 'index') : $accion;
    	#COMPRUEBA QUE EL MODULO AL QUE EL USUARIO INTENTA INGRESAR TENGA
    	#PERMISOS PARA PODER USARLO (NIVEL 1 DE VERIFICACION DE PERMISOS)
    	foreach ($this->mods as $mod) 
    	{
    		#COMPARA LA URL ENTRANTE (LA VARIABLE $MODULO QUE LLEGA POR PARAMETRO)
    		#CON LA URL DE TODOS LOS MODULOS QUE TIENEN EL USUARIO DISPONIBLES PARA
    		#PODER USAR, SI NO SE ENCUENTRA NO SE CUMPLE LA CONDICION
    		#SALE DEL CICLO Y REDIRECCIONA AL INDEX DEL DASHBOARD
            #return dd($mod);
    		if($mod->url_modulo == $modulo)
            {

                /**
                 * TODOS LOS MODULOS SE GUARDAN EN LA CARPETA "MODULOS".
                 * SI EL USUARIO POSEE EL PERMISO PARA ACCEDER AL MODULO SOLICITADO
                 * POR LA URL, ENTOCES SE CREA UN OBJETO DE LA CLASE DEL MODULO
                 * QUE SE INTENTA INGRESAR Y SE LLAMA AL METODO QUE ESTA ALMACENADO
                 * EN "ACCION" (POR DEFECTO ES INDEX)
                 * LA URL FINAL QUEDA: www.dominio.com/dashboard/{modulo}/{accion/metodo}

                 */

                $programa = ( $programa == '') ? $mod->nombre_modulo : $programa;
    			$this->controlador = 'App\\Http\\Controllers\\Modulos\\'.$mod->url_modulo.'\\'.$programa;
                $this->controlador = new $this->controlador($mod->id);

                $this->accion = $accion;
                return call_user_func_array([$this->controlador, $this->accion], [
                    'request'=> $request, 
                    'id' => $id
                ]);
            }
    	}
    	
        Session::flash('error-permisos', 'Usted no posee permisos para acceder a este modulo o no existe');
        return redirect()->to('/dashboard');
    }
}
