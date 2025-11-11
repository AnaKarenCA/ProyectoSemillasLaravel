<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'id_rol';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function usuarios()
    {
        return $this->hasMany(Configuracion::class, 'id_rolAsignado', 'id_rol');
    }

    public function menusAsignados()
    {
        return $this->hasMany(MenuAsignado::class, 'id_rol', 'id_rol');
    }
}
