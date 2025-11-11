<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEstadoYDescuentoToClientesTable extends Migration
{
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            if (!Schema::hasColumn('clientes', 'estado')) {
                $table->enum('estado', ['activo', 'inactivo'])
                      ->default('activo')
                      ->after('direccion');
            }

            if (!Schema::hasColumn('clientes', 'descuento')) {
                $table->decimal('descuento', 8, 2)
                      ->default(0)
                      ->after('estado');
            }
        });
    }

    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            if (Schema::hasColumn('clientes', 'estado')) {
                $table->dropColumn('estado');
            }

            if (Schema::hasColumn('clientes', 'descuento')) {
                $table->dropColumn('descuento');
            }
        });
    }
}
