<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VentaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function realiza_una_venta_y_actualiza_el_stock()
    {
        $user = User::factory()->create();
        $producto = Producto::factory()->create(['stock' => 10]);

        $this->actingAs($user)
             ->post('/ventas', [
                 'producto_id' => $producto->id,
                 'cantidad' => 2,
                 'precio_unitario' => $producto->precio
             ])
             ->assertRedirect('/ventas');

        $this->assertDatabaseHas('ventas', [
            'producto_id' => $producto->id,
            'cantidad' => 2
        ]);

        $this->assertEquals(8, $producto->fresh()->stock);
    }
}
