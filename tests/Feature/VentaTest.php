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
    public function test_crear_venta_exitosamente()
{
    $response = $this->post('/ventas', [
        'cliente_id' => 1,
        'productos' => [1, 2],
        'total' => 250
    ]);

    $response->assertStatus(200);
}

}
