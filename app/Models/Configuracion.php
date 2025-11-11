<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Configuracion extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre', 'apellido_paterno', 'apellido_materno',
        'usuario', 'contrasena', 'direccion',
        'correo_electronico', 'estado', 'id_rolAsignado', 'foto_perfil'
    ];

    public function setContrasenaAttribute($value)
    {
        $this->attributes['contrasena'] = Hash::make($value);
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rolAsignado', 'id_rol');
    }
}
