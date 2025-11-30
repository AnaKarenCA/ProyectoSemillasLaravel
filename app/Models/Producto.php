<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'codigo_barras',
        'nombre',
        'variante',
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
        'qr_code'
    ];

    // ------- GENERADOR AUTOMÁTICO SKU ---------
    public static function generarSKU($nombre)
    {
        $prefijo = strtoupper(Str::slug(substr($nombre, 0, 3), ''));

        $ultimo = self::where('codigo', 'LIKE', "$prefijo%")
                      ->orderBy('codigo', 'DESC')
                      ->first();

        if ($ultimo && preg_match('/(\d+)$/', $ultimo->codigo, $m)) {
            $num = str_pad($m[1] + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $num = "0001";
        }

        return $prefijo . "-" . $num;
    }

    // ------- GENERADOR EAN-13 -------
    public static function generarEAN13()
    {
        $base = "750" . str_pad(random_int(1, 999999999), 9, '0', STR_PAD_LEFT);

        $suma = 0;
        for ($i = 0; $i < 12; $i++) {
            $numero = intval($base[$i]);
            $suma += ($i % 2 == 0) ? $numero : $numero * 3;
        }
        $digito = (10 - ($suma % 10)) % 10;

        return $base . $digito;
    }

    // ------- GENERADOR QR / UUID -------
    public static function generarCodigoQR($nombre)
    {
        $slug = strtoupper(substr($nombre, 0, 3));
        $hash = strtoupper(substr(uniqid(), -5));
        return "PDT-$slug-$hash";
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id_categoria');
    }

    public function unidades()
    {
        return $this->hasMany(ProductoUnidad::class, 'id_producto');
    }
}
