<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';       // tu tabla antigua
    protected $primaryKey = 'id_usuario'; // clave primaria
    public $timestamps = false;          // si tu tabla no tiene created_at/updated_at

    protected $fillable = [
        'nombre',
        'usuario',
        'contrasena',
        // agrega otros campos que tengas
    ];

    public function getAuthPassword()
    {
        return $this->contrasena; // porque tu campo de password se llama "contrasena"
    }
}
