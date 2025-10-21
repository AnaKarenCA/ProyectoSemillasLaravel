<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    /** @test */
    public function carga_menu_con_permisos_correctos()
    {
        $menu = \App\Models\Menu::create([
            'nombre' => 'Inventario',
            'permiso' => 'admin', // obligatorio
        ]);

        $this->assertEquals('Inventario', $menu->nombre);
        $this->assertEquals('admin', $menu->permiso);
    }

}
