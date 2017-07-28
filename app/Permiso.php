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
}
