<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoUnidad extends Model
{
    protected $table = 'producto_unidades';
    protected $primaryKey = 'id_producto_unidad';

    protected $fillable = [
        'id_producto',
        'unidad',
        'factor_conversion',
        'precio_unitario'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
