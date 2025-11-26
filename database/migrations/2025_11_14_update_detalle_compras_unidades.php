<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDetalleComprasUnidades_20251114 extends Migration
{
    public function up()
    {
        Schema::table('detalle_compras', function (Blueprint $table) {
            $table->decimal('cantidad', 10, 3)->change();
            $table->string('unidad', 50)->default('kg')->after('cantidad');
        });
    }

    public function down()
    {
        Schema::table('detalle_compras', function (Blueprint $table) {
            $table->integer('cantidad')->change();
            $table->dropColumn('unidad');
        });
    }
}
