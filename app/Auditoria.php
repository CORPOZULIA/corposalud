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
    
    public static function auditoria($accion, $modulo_id, $user_id){
        Auditoria::create([
            'accion' => strtoupper( trim($accion) ),
            'modulo_id' => $modulo_id,
            'user_id' => $user_id,
        ]);
    }
}
