<?php

namespace App\Http\Controllers\Modulos\corposalud\Models;

use Illuminate\Database\Eloquent\Model;

class DisponibilidadView extends Model
{
   	protected $table = 'corposalud.disponibilidad_funcionario';

   	protected $fillable = [ 
   		'a_pagar', 'monto_otorgado', 'nombres', 'apellidos', 'cedula', 'monto_disponible' 
   	];
}
