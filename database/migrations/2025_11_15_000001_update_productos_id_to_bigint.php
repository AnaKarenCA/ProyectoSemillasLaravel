<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1️⃣ Eliminar foreign key real en detalle_ventas
        Schema::table('detalle_ventas', function (Blueprint $table) {
            $table->dropForeign('fk_dv_producto');
        });

        // 2️⃣ Eliminar foreign key real en devoluciones
        Schema::table('devoluciones', function (Blueprint $table) {
            $table->dropForeign('devoluciones_ibfk_2');
        });

        // 3️⃣ Cambiar tipo del ID en productos
        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_producto')->change();
        });

        // 4️⃣ Volver a crear las claves foráneas correctamente con cascade
        Schema::table('detalle_ventas', function (Blueprint $table) {
            $table->foreign('id_producto')
                ->references('id_producto')
                ->on('productos')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::table('devoluciones', function (Blueprint $table) {
            $table->foreign('id_producto')
                ->references('id_producto')
                ->on('productos')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down()
    {
        // Restaurar a int normal si se revierte
        Schema::table('productos', function (Blueprint $table) {
            $table->integer('id_producto')->change();
        });
    }
};
