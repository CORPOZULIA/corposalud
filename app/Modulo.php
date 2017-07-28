<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'general.modulos';
    protected $fillable = ['nombre_modulo', 'descripcion_modulo', 'url_modulo'];

    public function ModPerUser()
    {
    	return $this->hasMany('App\ModPerUser');
    }

    public function programas()
    {
    	return $this->hasMany('App\Programa');
    }
}
