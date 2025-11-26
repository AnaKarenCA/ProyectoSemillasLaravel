<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'precio_por_kg',
        'costo',
        'costo_por_kg',
        'stock',
        'stock_min',
        'unidad_venta',
        'base_unidad',
        'categoria_id',
        'ubicacion',
        'estado',
        'imagenes',
        'codigo',
        'codigo_barras',
        'id_proveedor'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id_categoria');
    }

    public function unidades()
    {
        return $this->hasMany(ProductoUnidad::class, 'id_producto');
    }


    public function unidadPorNombre($unidad)
    {
        return $this->unidades()->where('unidad', $unidad)->first();
    }

    /**
     * Calcula el precio REAL según la cantidad y la unidad seleccionada
     */
    public function calcularPrecioPorCantidad($cantidad, $unidad)
    {
        $u = $this->unidadPorNombre($unidad);

        if ($u) {
            $cantidadEnBase = $cantidad * (float)$u->factor;
        } else {
            $cantidadEnBase = $cantidad;
        }

        // Precio por kg o por litro → basado en 1000 unidades base
        if (in_array($this->base_unidad, ['g', 'ml'])) {
            if ($this->precio_por_kg) {
                return ($this->precio_por_kg / 1000) * $cantidadEnBase;
            }
        }

        // Precio por pieza o unidad normal
        return $this->precio * $cantidad;
    }
}
