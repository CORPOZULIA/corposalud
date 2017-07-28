<?php

use Illuminate\Database\Seeder;
use App\Modulo;
use App\Programa;

class ModulosTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Modulo::count() > 0)
        {
            print "Truncando tabla modulos...";
            DB::statement('TRUNCATE modulos CASCADE');
        }
        print "Creando modulos...";
    	
    	/**
    	 * ENUNCIADO DE LOS MODULOS QUE SE PRECARGARAN EN EL SISTEMA
    	 * UN ARREGLO DE ARREGLOS DONDE, LA PRIMERA CLAVE REPRESENTA
    	 * EL NOMBRE DEL MODULO EL CUAL ES UN ARRAY QUE POSEE
    	 * SUS CARACTERISTICAS (DESCRIPCION, URL ETC), Y UN ARRAY DE PROGRAMAS
    	 * @var ARRAY
    	 */
        
        $modulos = include config_path('modulos.php');
        foreach ($modulos as $posicion => $modulo) 
        {
        	$objModulo = Modulo::create([
        		'nombre_modulo' => $modulo['nombre_modulo'],
        		'descripcion_modulo' => $modulo['descripcion_modulo'],
        		'url_modulo'	=> $modulo['url_modulo'],
        	]);

        	$objPrograma = null;
        	$i = 0;

            /**
             * COMPROBACIÓN DE QUE EXISTEN PROGRAMAS DENTRO
             * DEL MODULO   
             */
            if(array_key_exists('programas', $modulo))
            {
            	foreach($modulo['programas'] as $programa => $atributos)
            	{
            		$objPrograma[$i] = new Programa([
            			'nombre_programa' => $atributos['nombre_programa'],
            			'url_programa'	 => $atributos['url_programa'],
            			'descripcion_programa' => $atributos['descripcion_programa'],
            		]);
            		$i++;
            	}
            	$objModulo->programas()->saveMany($objPrograma);
            }

        	$objModulo->ModPerUser()->saveMany([
        		new App\ModPerUser(['user_id' => 1, 'permiso_id' => 1]),
        		new App\ModPerUser(['user_id' => 1, 'permiso_id' => 2]),
        		new App\ModPerUser(['user_id' => 1, 'permiso_id' => 3]),
        		new App\ModPerUser(['user_id' => 1, 'permiso_id' => 4]),
        	]);
        }
    }
}
