<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_ver_la_vista_de_login()
    {
        $this->get('/login')->assertStatus(200)->assertViewIs('auth.login');
    }

    /** @test */
    public function un_usuario_puede_iniciar_sesion()
    {
        $user = User::factory()->create([
            'email' => 'admin@correo.com',
            'password' => bcrypt('123456')
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@correo.com',
            'password' => '123456'
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function no_puede_iniciar_con_datos_invalidos()
    {
        $response = $this->post('/login', [
            'email' => 'falso@correo.com',
            'password' => 'incorrecta'
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    /** @test */
    public function puede_cerrar_sesion()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
             ->post('/logout')
             ->assertRedirect('/');

        $this->assertGuest();
    }
}
