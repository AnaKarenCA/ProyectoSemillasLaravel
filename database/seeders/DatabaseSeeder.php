<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crea 10 usuarios de prueba con la fábrica
        Usuario::factory(10)->create();

        // Crea un usuario específico (por ejemplo, administrador de prueba)
        Usuario::create([
            'nombre' => 'Administrador',
            'usuario' => 'admin',
            'contrasena' => Hash::make('123456'),
        ]);
    }
}
