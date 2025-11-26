<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('producto_unidades', function (Blueprint $table) {
            $table->id('id_producto_unidad');
            $table->unsignedBigInteger('id_producto');

            // nombre de la unidad: kg, g, 1/2 kg, pieza, sobre, litro, etc.
            $table->string('unidad', 50);

            // factor que convierte a kilos o unidad base
            // ejemplo: 1 kg = 1, 100 g = 0.1, 1/2 kg = 0.5, pieza = 1 (si manejas pieza como base)
            $table->decimal('factor_conversion', 12, 6);

            // precio proporcional calculado automáticamente
            $table->decimal('precio_unitario', 12, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('producto_unidades');
    }
};
