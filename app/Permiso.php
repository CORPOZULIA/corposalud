<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = "general.permisos";
    protected $fillable = ['nombre_permiso', 'descripcion_permiso'];

    public function ModPerUser()
    {
    	return $this->hasMany('App\ModPerUser');
    }
    
    public static function check_permisos($accion, $user_id, $modulo_id)
    {
        $permisos = ModPerUser::where('user_id', $user_id)
                                ->where('modulo_id', $modulo_id)->get();

        foreach ($permisos as $permiso) {
            
            if( $permiso->permiso->nombre_permiso == $accion) return true;
        }
        return false;
    }
}
