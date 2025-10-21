<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function se_puede_crear_usuario()
    {
        $usuario = Usuario::factory()->create();

        $this->assertDatabaseHas('usuarios', [
            'id_usuario' => $usuario->id_usuario,
            'usuario' => $usuario->usuario
        ]);
    }
}
