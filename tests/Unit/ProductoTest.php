<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductoTest extends TestCase
{
    use RefreshDatabase; // resetea la base en cada test

    /** @test */
    public function se_puede_crear_un_producto()
    {
        $producto = Producto::create([
            'nombre' => 'Chile Seco',
            'descripcion' => 'Producto de prueba',
            'precio' => 10.50,
            'stock' => 100,
        ]);

        $this->assertDatabaseHas('productos', [
            'nombre' => 'Chile Seco',
            'precio' => 10.50
        ]);
    }

    /** @test */
    public function no_se_puede_crear_producto_sin_nombre()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Producto::create([
            'descripcion' => 'Sin nombre',
            'precio' => 5.00,
            'stock' => 10,
        ]);
    }
}
