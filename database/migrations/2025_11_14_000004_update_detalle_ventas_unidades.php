<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('detalle_ventas', function (Blueprint $table) {

            if (!Schema::hasColumn('detalle_ventas', 'id_producto_unidad')) {
                $table->unsignedBigInteger('id_producto_unidad')->nullable();
            }

            if (!Schema::hasColumn('detalle_ventas', 'cantidad_convertida_kg')) {
                $table->decimal('cantidad_convertida_kg', 12, 4)->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('detalle_ventas', function (Blueprint $table) {
            $table->dropColumn(['id_producto_unidad', 'cantidad_convertida_kg']);
        });
    }
};
