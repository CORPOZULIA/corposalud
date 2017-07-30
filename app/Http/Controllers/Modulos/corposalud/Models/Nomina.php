<?php

namespace App\Http\Controllers\Modulos\corposalud\Models;

use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{
    protected $table = 'corposalud.nominas';
    protected $fillable = ['descripcion_nomina', 'codigo_nomina'];


}
