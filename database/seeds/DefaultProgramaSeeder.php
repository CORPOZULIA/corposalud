<?php

use Illuminate\Database\Seeder;

use App\Programa;

class DefaultProgramaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	Programa::create([
       		'nombre_programa'	=>	'Gestion de usuarios',
       		'url_programa'		=>	'usuarios/Usuarios',
       		'modulo_id'			=>	1,
       		'descripcion_programa' => 'Programa para la gestion de usuarios',
       	]);
    }
}
