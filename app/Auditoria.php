<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table="general.auditoria";

    protected $fillable = ['modulo', 'user_id', 'programa', 'descripcion'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
