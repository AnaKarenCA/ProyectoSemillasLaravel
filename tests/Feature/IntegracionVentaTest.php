<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IntegracionVentaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function verifica_integracion_entre_producto_y_vista_de_venta()
    {
        // Simulamos un producto en la BD
        $producto = Producto::create([
            'nombre' => 'Chile seco',
            'precio' => 25.50,
            'stock' => 50,
            'categoria_id' => 1,
        ]);

        // Accedemos a la vista de venta
        $response = $this->get('/venta');

        // Verificamos que aparezca el producto en la vista
        $response->assertStatus(200);
        $response->assertSee('Chile seco');
        $response->assertSee('25.50');
    }
}
