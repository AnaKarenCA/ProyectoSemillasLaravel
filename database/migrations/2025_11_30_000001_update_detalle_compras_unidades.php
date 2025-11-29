<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDetalleComprasUnidades extends Migration

{
    public function up()
    {
        Schema::table('detalle_compras', function (Blueprint $table) {
            if (!Schema::hasColumn('detalle_compras', 'unidad_venta_id')) {
                $table->unsignedBigInteger('unidad_venta_id')->nullable()->after('cantidad');
            }
        });
    }

    public function down()
    {
        Schema::table('detalle_compras', function (Blueprint $table) {
            if (Schema::hasColumn('detalle_compras', 'unidad_venta_id')) {
                $table->dropColumn('unidad_venta_id');
            }
        });
    }
}
