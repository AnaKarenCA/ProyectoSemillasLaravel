<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // necesario para Auth
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    // Nombre de la tabla en la base de datos
    protected $table = 'usuarios';

    // Clave primaria
    protected $primaryKey = 'id_usuario';

    // Si no usas timestamps (created_at, updated_at)
    public $timestamps = false;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'usuario',
        'contrasena',
        // agrega otros campos si tienes
    ];

    // Si tu contraseña se llama "contrasena", Laravel necesita que el método getAuthPassword lo devuelva
    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}
