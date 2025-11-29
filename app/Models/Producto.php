<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'codigo_barras',
        'nombre',
        'stock',
        'stock_min',
        'base_unidad',
        'precio',
        'costo',
        'iva',
        'categoria_id',
        'unidad_venta',
        'unidad_venta_id',
        'descripcion',
        'imagenes',
        'ubicacion',
        'estado',
        'permite_devolucion',
        'activo',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id_categoria');
    }

    public function unidades()
    {
        return $this->hasMany(ProductoUnidad::class, 'id_producto');
    }
}
