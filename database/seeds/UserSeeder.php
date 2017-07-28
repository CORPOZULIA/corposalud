<?php

use Illuminate\Database\Seeder;
use App\Persona;
use App\Empleado;
use App\ModPerUser;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$persona = new Persona([
    		'nombres' => 'Administrador',
    		'apellidos' => 'Del Sistema',
    		'cedula' => 'No aplica',
    		'direccion' => 'No aplica',
    		'telefono_habitacion' => 'No aplica',
    		'telefono_personal' => 'No aplica',
    		'email' => 'admin@root'
    	]);

    	if($persona->save())
    	{
    		if($persona->empleado()->save(new Empleado([])))
    		{
    			$persona->empleado->user()->save(
    				new User([
    					'usuario' => 'admin',
    					'password' => 'root'
    				])
    			);
    		}
    	}


    	if($persona->empleado->user != null)
    	{
    		$persona->empleado->user->permisos()->saveMany([

    			new ModPerUser([
    				'modulo_id' => 1, 
    				'user_id' => $persona->empleado->user->id, 
    				'permiso_id' => 1
    			]),
    			new ModPerUser([
    				'modulo_id' => 1, 
    				'user_id' => $persona->empleado->user->id, 
    				'permiso_id' => 2
    			]),
    			new ModPerUser([
    				'modulo_id' => 1, 
    				'user_id' => $persona->empleado->user->id, 
    				'permiso_id' => 3
    			]),
    			new ModPerUser([
    				'modulo_id' => 1, 
    				'user_id' => $persona->empleado->user->id, 
    				'permiso_id' => 4
    			]),
    		]);
    	}
    }
}
