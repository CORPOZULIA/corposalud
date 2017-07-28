<?php

use Illuminate\Database\Seeder;
use App\Permiso;
use App\Persona;
use Faker\Factory;

use App\Http\Controllers\Modulos\corposalud\Models\Beneficiario;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permiso::create([
        	'nombre_permiso' => 'CREATE',
        	'descripcion_permiso' => 'Crear un registro'
        ]);

        Permiso::create([
        	'nombre_permiso' => 'DELETE',
        	'descripcion_permiso' => 'Crear un registro'
        ]);


        Permiso::create([
        	'nombre_permiso' => 'UPDATE',
        	'descripcion_permiso' => 'Crear un registro'
        ]);


        Permiso::create([
        	'nombre_permiso' => 'SEARCH',
        	'descripcion_permiso' => 'Crear un registro'
        ]);

        $faker = Factory::create();
        $generos = ['Male', 'FeMale'];

        /*for($i = 0; $i< 130 ; $i++)
        {
            Persona::create([
                'nombres' => call_user_func_array( [$faker, 'firstName'.$generos[array_rand($generos)]], []),
                'apellidos' => call_user_func_array( [$faker, 'lastName'] , []),
                'email' => $faker->unique()->email,
                'direccion' => 'No aplica',
                'cedula' => $faker->unique()->ean8,
                'telefono_personal' => $faker->unique()->e164PhoneNumber,
                'telefono_habitacion' => $faker->unique()->tollFreePhoneNumber
            ])->beneficiario()->save( new Beneficiario(['disponibilidad_id' => 1]));
        }*/
    }
}
