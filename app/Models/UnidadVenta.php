<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadVenta extends Model
{
    // Tabla existente en tu BD
    protected $table = 'unidades_venta';

    // PK en esa tabla es 'id'
    protected $primaryKey = 'id';

    // No usas timestamps en esa tabla (según describe)
    public $timestamps = false;

    // Campos rellenables (si los necesitas)
    protected $fillable = [
        'nombre',
    ];
}
