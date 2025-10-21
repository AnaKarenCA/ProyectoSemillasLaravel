<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Usuario;

class LoginSystemTest extends TestCase
{
    use RefreshDatabase; // resetea la base de datos de pruebas automáticamente

    public function test_user_can_login()
    {
        $user = Usuario::factory()->create([
            'usuario' => 'juan',
            'contrasena' => bcrypt('123456'),
        ]);

        $response = $this->post('/login', [
            'usuario' => 'juan',
            'contrasena' => '123456',
        ]);

        $response->assertStatus(302); // redirección después de login
        $this->assertAuthenticatedAs($user);
    }
}
