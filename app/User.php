<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'general.users';
    protected $usuario ="general.usuario";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario', 'empleado_id', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    }

    public function permisos()
    {
        return $this->hasMany('App\ModPerUser');
    }


    /**
    *   ENCRIPTA LA PASSWORD QUE VIENE DESDE
    *   EL FORMULARIO (REFERENCIA: https://laravel.com/docs/5.2/eloquent-mutators#accessors-and-mutators)
    */
    public function setPasswordAttribute($old){
        $this->attributes['password'] = bcrypt($old);
    }

    public function auditoria()
    {
        return $this->hasMany('App\Auditoria');
    }
}
