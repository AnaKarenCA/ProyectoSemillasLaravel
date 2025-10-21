<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Producto;

class ExistenciasTest extends TestCase
{
    /** @test */
    public function calcula_existencias_correctamente()
    {
        $producto = new Producto(['stock' => 50]);
        $cantidadVendida = 10;
        $nuevoStock = $producto->stock - $cantidadVendida;

        $this->assertEquals(40, $nuevoStock);
    }
}
