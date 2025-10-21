<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Usuario;

class LoginAcceptanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_and_access_home()
    {
        // Crear un usuario de prueba
        $user = Usuario::factory()->create([
            'usuario' => 'ana',
            'contrasena' => bcrypt('password123'),
        ]);

        // Simular formulario de login
        $response = $this->post('/login', [
            'usuario' => 'ana',
            'contrasena' => 'password123',
        ]);

        // Debe redirigir a /home
        $response->assertRedirect('/home');

        // Usuario autenticado
        $this->assertAuthenticatedAs($user);

        // Acceder a la página de inicio
        $homeResponse = $this->get('/home');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Bienvenido');
    }
}
