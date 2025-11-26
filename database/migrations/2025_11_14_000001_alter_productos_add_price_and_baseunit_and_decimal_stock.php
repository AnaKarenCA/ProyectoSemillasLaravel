<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProductosAddPriceAndBaseunitAndDecimalStock extends Migration
{
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            // Cambiamos stock a decimal para soportar fracciones (gramos, ml)
            // solo si la columna existe como int; de lo contrario se crea
            $table->decimal('stock', 12, 3)->default(0)->change();

            // Precio por kg (para productos medidos por peso)
            if (!Schema::hasColumn('productos', 'precio_por_kg')) {
                $table->decimal('precio_por_kg', 12, 4)->nullable()->after('precio');
            }
            if (!Schema::hasColumn('productos', 'costo_por_kg')) {
                $table->decimal('costo_por_kg', 12, 4)->nullable()->after('precio_por_kg');
            }

            // Unidad base para el producto: 'g' | 'ml' | 'piece'
            if (!Schema::hasColumn('productos', 'base_unidad')) {
                $table->enum('base_unidad', ['g', 'ml', 'piece'])->default('piece')->after('stock');
            }

            // Mantener unidad_venta textual (opcional)
            if (!Schema::hasColumn('productos', 'unidad_venta')) {
                $table->string('unidad_venta')->nullable()->after('base_unidad');
            }
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            // revertir cambios si es necesario
            // Nota: cambiar decimal a int podría perder datos; dejar comentado si no quieres revertir automáticamente.
            //$table->integer('stock')->change();

            $table->dropColumn(['precio_por_kg', 'costo_por_kg', 'base_unidad']);
        });
    }
}
