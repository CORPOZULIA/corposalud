<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Persona;
use App\Empleado;
use App\User;
use App\Permiso;
use App\Modulo;
use DB;

class ModPerUser extends Model
{
    protected $table = "general.modulos_permisos_users";

    protected $fillable = ['modulo_id', 'permiso_id', 'user_id'];

    public function permiso()
    {
    	return $this->belongsTo('App\Permiso');
    }

    public function modulo()
    {
    	return $this->belongsTo('App\Modulo');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public static function getModulos($userid = 0)
    {
        $mods = DB::table('general.personas')->where('general.users.id', $userid)
                    ->where('general.personas.edo_reg', 1)
                    ->join('general.empleados', 'general.empleados.persona_id', '=', 'general.personas.id')
                    ->join('general.users', 'general.empleados.id', '=', 'general.users.empleado_id')
                    ->join('general.modulos_permisos_users', 'general.modulos_permisos_users.user_id', '=', 'general.users.id')
                    ->join('general.modulos', 'general.modulos.id', '=', 'general.modulos_permisos_users.modulo_id')
                    ->select('general.modulos.*')->distinct();

        return $mods->get();
    }
}
