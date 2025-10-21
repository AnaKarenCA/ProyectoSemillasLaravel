<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function redirige_a_home_si_esta_autenticado()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
             ->get('/home')
             ->assertStatus(200)
             ->assertViewIs('home');
    }

    /** @test */
    public function redirige_a_login_si_no_esta_autenticado()
    {
        $this->get('/home')->assertRedirect('/login');
    }
}
