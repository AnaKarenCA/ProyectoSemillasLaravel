<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Primero eliminar las foreign keys que dependen de productos
        Schema::table('productos', function (Blueprint $table) {
            // Ninguna FK depende de id_producto, así que no eliminamos nada
        });

        // Cambiar el tipo de id_producto a BIGINT UNSIGNED
        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_producto')->change();
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->integer('id_producto')->change();
        });
    }
};
