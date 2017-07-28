<?php

namespace App\Http\Controllers\Modulos\corposalud\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiario extends Model
{
    protected $table = 'corposalud.beneficiarios';

    protected $fillable = [ 'persona_id', 'disponibilidad_id', ];


    public function persona()
    {
    	return $this->belongsTo('App\Persona');
    }

    public function facturas()
    {
    	return $this->hasMany('App\Http\Controllers\Modulos\corposalud\Models\Factura');
    }
}
