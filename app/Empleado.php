<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Persona;

class Empleado extends Model
{
    protected $table = "general.empleados";

    protected $fillable = ['fecha_inactividad'];

    private $persona;

    /**
     * RELACIONES - TIENE
     */
    
    public function user()
    {
    	return $this->hasOne('App\User');
    }

    /**
     * RELACIONES - PERTENECE
     */

    public function persona()
    {
    	return $this->belongsTo('App\Persona');
    }

   
}
