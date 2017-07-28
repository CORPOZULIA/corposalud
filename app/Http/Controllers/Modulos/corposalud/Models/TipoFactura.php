<?php

namespace App\Http\Controllers\Modulos\corposalud\Models;

use Illuminate\Database\Eloquent\Model;

class TipoFactura extends Model
{
    protected $table = 'corposalud.tipo_facturas';

    protected $fillable = ['codigo_factura', 'descripcion_factura'];


    public function facturas()
    {
    	return $this->hasMany('App\Http\Controllers\Modulos\corposalud\Models\Factura');
    }
}
