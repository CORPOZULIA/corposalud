<?php

namespace App\Http\Controllers\Modulos\corposalud\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Disponibilidad extends Model
{
	protected $table = "corposalud.disponibilidades";

	protected $fillable = [ 'monto_disponible' ];



	public static function getDisponibilidad($cedula='')
	{
		$query =  DB::table('corposalud.disponibilidad_funcionario')
					->where('a_pagar', '>', 0);

		if($cedula!='')
			$query->where('cedula', $cedula);

		return $query->get();
	}
}
