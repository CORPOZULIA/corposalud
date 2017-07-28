<?php
use App\Persona;
use Faker\Factory;

use App\Http\Controllers\Modulos\corposalud\Models\Beneficiario;
class PersonasFakerSeeder extends Seeder
{
   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Factory::create();
        $generos = ['Male', 'FeMale'];

        for($i = 0; $i< 20 ; $i++)
        {
        	Persona::create([
        		'nombres' => call_user_func_array( [$faker, 'firstName'.$generos[array_rand($generos)]], ''),
        		'apellidos' => call_user_func_array( [$faker, 'lastName'] , []),
        		'email' => $faker->unique()->email,
        		'direccion' => 'No aplica',
        		'cedula' => $faker->unique()->ean8,
        		'telefono_personal' => $faker->unique()->e164PhoneNumber,
        		'telefono_habitacion' => $faker->unique()->tollFreePhoneNumber
        	]);
        }
    }
}
