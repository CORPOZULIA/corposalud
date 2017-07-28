<?php

namespace App\Http\Controllers\Modulos\corposalud\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
   protected $table = 'corposalud.detalles_facturas';

   protected $fillable = [
   		'descripcion_gasto', 'factura_id', 'costo', 'iva'
   ];


   public function factura()
   {
   		return $this->belongsTo('App\Http\Controllers\Modulos\corposalud\Models\Factura');
   }
}
