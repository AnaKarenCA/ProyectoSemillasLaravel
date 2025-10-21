<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Producto;

class UITestVenta extends DuskTestCase
{
    /** @test */
    public function el_usuario_puede_realizar_una_venta()
    {
        $this->browse(function (Browser $browser) {
            // Crear datos simulados
            $producto = Producto::factory()->create([
                'nombre' => 'Semilla de girasol',
                'precio' => 20.00,
                'stock' => 10,
            ]);

            // Iniciar sesión o ir directo a la vista
            $browser->visit('/venta')
                ->assertSee('Punto de Venta')
                ->type('#product-search', 'Semilla de girasol')
                ->pause(1000)
                ->click('button:contains("Agregar")') // depende del botón real
                ->pause(500)
                ->type('#cambio-input', '100')
                ->click('#realizar-venta-btn')
                ->pause(1000)
                ->assertSee('Venta realizada con éxito');
        });
    }
}
