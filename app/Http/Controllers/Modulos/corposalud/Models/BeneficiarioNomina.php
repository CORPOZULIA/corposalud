<?php

namespace App\Http\Controllers\Modulos\corposalud\Models;

use Illuminate\Database\Eloquent\Model;

class BeneficiarioNomina extends Model
{
    protected $table = 'corposalud.beneficiario_nominas';
    protected $fillable = [
    	'beneficiario_id', 'nomina_id'
    ];
}
