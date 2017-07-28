<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PersonaSugau extends Model
{
	protected $table = 'public.sno_personal';
	protected $fillable = ['nomper'];
	public $timestamps = false;

     public function user()
     {
     	return $this->hasOne('App\User');
     }

     public static function getPersona($cedula)
     {
     	$result = DB::table('public.sno_personal')->where('general.personas.cedula', $cedula)
     					->leftJoin('general.personas', 'public.sno_personal.cedper', '=', 'general.personas.cedula' )
     					->select('general.personas.nombres', 'public.sno_personal.nomper');
     	return $result->get();
     }


     public static function getPersonasugau($cedula)
     {
     	$result = DB::table('public.sno_personal')
     				->where('public.sno_personal.cedper', '=', $cedula);

     	return $result->get();
     }


}
