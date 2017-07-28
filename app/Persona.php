<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
   protected $table = "general.personas";

   protected $fillable = [
   		'nombres', 'apellidos', 'email', 'direccion', 
   		'cedula', 'telefono_personal', 'telefono_habitacion', 'codper'
   ];

   public function empleado()
   {
   		return $this->hasOne('App\Empleado');
   }

   public function cliente()
   {
   		return $this->hasOne('App\Cliente');
   }

   public function beneficiario()
   {
      return $this->hasOne('App\Http\Controllers\Modulos\corposalud\Models\Beneficiario');
   }
}
