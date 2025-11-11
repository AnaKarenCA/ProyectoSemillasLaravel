<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCamposContablesToComprasTable extends Migration
{
    public function up(): void
    {
        Schema::table('compras', function (Blueprint $table) {
            if (!Schema::hasColumn('compras', 'folio_factura')) {
                $table->string('folio_factura', 50)->nullable();
            }

            if (!Schema::hasColumn('compras', 'metodo_pago')) {
                $table->string('metodo_pago', 50)->nullable();
            }

            if (!Schema::hasColumn('compras', 'monto_total')) {
                $table->decimal('monto_total', 10, 2)->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('compras', function (Blueprint $table) {
            if (Schema::hasColumn('compras', 'folio_factura')) {
                $table->dropColumn('folio_factura');
            }
            if (Schema::hasColumn('compras', 'metodo_pago')) {
                $table->dropColumn('metodo_pago');
            }
            if (Schema::hasColumn('compras', 'monto_total')) {
                $table->dropColumn('monto_total');
            }
        });
    }
}
