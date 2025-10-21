<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_usuario_autenticado_puede_generar_un_reporte()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
             ->get('/reportes/ventas')
             ->assertStatus(200)
             ->assertViewIs('reportes.ventas');
    }

    /** @test */
    public function un_invitado_no_puede_acceder_a_reportes()
    {
        $this->get('/reportes/ventas')
             ->assertRedirect('/login');
    }
}
