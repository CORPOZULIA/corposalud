<?php

namespace App\Http\Controllers\Modulos\corposalud\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Factura extends Model
{
    protected $table = 'corposalud.facturas';

    protected $fillable = [
    	'total', 'fecha_factura', 'tipo_factura_id', 'numero_factura', 'beneficiario_id', 'created_at'
    ];


    public function detalles()
    {
    	return $this->hasMany('App\Http\Controllers\Modulos\corposalud\Models\DetalleFactura');
    }

    public function beneficiario()
    {
    	return $this->belongsTo('App\Http\Controllers\Modulos\corposalud\Models\Beneficiario');
    }

    public function tipo_factura()
    {
    	return $this->belongsTo('App\Http\Controllers\Modulos\corposalud\Models\TipoFactura');
    }

    public function setCreatedAtAttribute($old)
    {
          $fecha = Carbon::now();
         $this->attributes['created_at'] = $fecha->year.'-'.$fecha->month.'-'.$fecha->day;
    }

    public function setFechaFacturaAttribute($old)
    {
          $fecha = Carbon::now();
         $this->attributes['fecha_factura'] = $fecha->year.'-'.$fecha->month.'-'.$fecha->day;
    }
}
