<?php
/**
 * CONTROLADOR DE USUARIOS:
 * ESTE ARCHIVO (MODULO), GESTIONA TODO LO RELACIONADO CON EL MODULO DE USUARIOS
 * DESDE LA CREACIÓN DE UN USUARIO HASTA LA ASIGNACIÓN DE PERMISOS Y ELIMINACIÓN 
 * DEL MISMO
 */

namespace App\Http\Controllers\Modulos;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\ModPerUser;
use App\User;
use App\Persona;
use App\Empleado;
use App\Modulo;
use Storage;

class Usuarios extends Controller
{
	private $mods;
    private $modulo_id;

	public function __construct($id)
	{
		$this->mods = ModPerUser::getModulos(Auth::user()->id);
        $this->modulo_id = $id;
	}

    public function index($request)
    {
    	return view('intranet.listar_usuarios', [
    		'modulos' => $this->mods,
    		'personas' => Persona::where('edo_reg', 1)->get()
    	]);
    }

    public function formulario($request,$form)
    {
        if(true)
            $form = formularios($request, $form);
        else return redirect()->to('/dashboard/usuarios');

        return $form;
    }

    public function consultar($request, $cedula)
    {
        if($request->ajax())
        {
            $persona = Persona::where('cedula', '=', $cedula)->get()->toArray();
            $persona[0]['fail'] = empty($persona[0]);
       
            return json_encode($persona[0]);
        }
    }

    public function crear($request, $info)
    {
        /**
         * ESTA FUNCION CREA REGISTROS DE USUARIOS:
         * PRIMERO BUSCA UNA PERSONA POR SU CEDULA LA CUAL LLEGA COMO PARAMETRO
         * POR LA URL POST, CON LA FINALIDAD DE COMPROBAR QUE EXISTE
         * UNA PERSONA EN LA BASE DE DATOS CON ESA CEDULA
         * SI LA CONSULTA RETORNA UN ARRAY VACIO (PRIMER IF)
         * ENTONCES CREA UN REGISTRO EN LA TABLA DE PERSONAS
         */

        $persona = Persona::where('cedula', '=', $request->input('cedula'))
                    ->get();

        $persona_fields = $request->except([
            'usuario', 'password', 'password2', '_token', 'user_id'
        ]);
       
        if(empty($persona[0]) && $this->_auth('CREATE') )
        {
            $persona = new Persona($persona_fields);
            if($persona->save())
            {
                if($persona->empleado()->save(new Empleado()))
                {
                   $nuevo = $persona->empleado->user()->save(
                        new User([
                            'usuario' => $request->input('usuario'),
                            'password' => bcrypt($request->input('password'))
                        ])
                    );
                }
            }
        }

        /**
         * SI EXISTE UNA PERSONA EN LA TABLA CON LA CEDULA 
         * PERO NO TIENE UN REGISTRO COMO EMPLEADO ASOCIADO ENTONCES CREA
         * PRIMERO EL REGISTRO EN LA TABLA EMPELADOS 
         */
        else if($persona[0]->empleado == null && $this->_auth('CREATE'))
        {
            $persona[0]->empleado = $persona[0]->empleado()->save( new Empleado([]) );

            $persona[0]->empleado->user()->save(
                new User([
                    'usuario' => $request->input('usuario'),
                    'password' => bcrypt($request->input('password'))
                ])
            );
        }

        /**
         * SI EXISTE UNA PERSONA CON ESA CEDULA, TIENE UN REGISTRO COMO EMPLEADO
         * Y UN USUARIO INACTIVO (QUE PUDO HABE SIDO SUPRIMIDO ANTERIORMENTE)
         * SE REACTIVA EL REGISTRO Y SE ACTUALIZA CON LOS NUEVOS DATOS 
         * DE LA NUEVA CUENTA DEL USUARIO (CON LA FINALIDAD DE NO TENER REGISTROS)
         * MULTIPLES CON LA MISMA FINALIDAD
         */
        else if($persona[0]->empleado->user != null && $persona[0]->empleado->user->edo_reg == 0 && $this->_auth('CREATE'))
        {
            $persona[0]->empleado->user->edo_reg = 1;
            $persona[0]->empleado->user->usuario = $request->input('usuario');
            $persona[0]->empleado->user->password = bcrypt($request->input('password'));
            $persona[0]->empleado->user->save();
                
        }
        else
        {
            if($this->_auth('CREATE'))
                $persona[0]->empleado->user()->save(
                    new App\User([
                        'usuario' => $request->input('usuario'),
                        'password' => bcrypt($request->input('password'))
                    ])
                );
        }

        return redirect()->to('dashboard/usuarios');

    }

    public function DELETE($request, $id)
    {
        /**
         * FUNCION DELETE, TIENE LA TAREA DE SUPRIMIR UN REGISTRO
         * DE LA TABLA DE USUAROS (COLOCA SU EDO REG EN 0)
         */

        $user = User::find($request->input('id'));
        if($user!= null && $this->_auth('DELETE')) 
        {
            $user->edo_reg = 0;
            if($user->save()) return json_encode(['fail' => false]);
        }
        return json_encode(['fail' => true]);
    }

    /**
     * [asignar_permisos darle permisos a usuarios]
     * @param  [object] $request [request]
     * @param  [string] $accion  [<id o cedula del usuario>]
     * @return [redirect]          [redirecciona al modulo usuarios de dashboard]
     */
    public function asignar_permisos($request, $accion)
    {
        $user = User::find($request->input('user_id'));
        if($this->_auth('UPDATE'))
        {
            $permisos= $request->input('permiso');
           if($request->input('opcion') == "asignar")
           {
                $obj_array_permisos = [];
                for($i=0; $i<count($permisos); $i++)
                {
                    $obj_array_permisos[$i] = new ModPerUser([
                        'modulo_id' => $request->input('modulo_id'),
                        'permiso_id' => $permisos[$i],
                        'user_id' => $request->input('user_id')
                    ]);
                }

                $user->permisos()->saveMany($obj_array_permisos);
            }
            else
            {
                $permisos = ModPerUser::where('user_id', $request->input('user_id'))
                                        ->where('modulo_id', $request->input('modulo_id'))->get();

                for($i = 0; $i< count($permisos); $i++)
                {
                    $permisos[$i]->delete();
                }
            }
        }
        return redirect()->to('/dashboard/usuarios');
    }

    public function consultar_modulo($request, $modulo_id)
    {
        $permisos = ModPerUser::where('modulo_id', $modulo_id)
                                ->where('user_id', $request->input('user_id'))->get();

        $permisologia = [];

        for($i = 0; $i< count($permisos) ; $i++)
        {
            $permisologia['permiso'][$i] = $permisos[$i]->permiso->nombre_permiso;
        }

        return $permisologia;
    }


    private function _auth($accion)
    {
        $permisos = ModPerUser::where('user_id', Auth::user()->id)->get();
        foreach ($permisos as $permiso) 
        {
            if($permiso->permiso->nombre_permiso == $accion)
                return true;
        }
        return false;
    }

}