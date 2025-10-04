<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detalle_ventas', function (Blueprint $table) {
            // Primero eliminar la foreign key existente
            $table->dropForeign(['id_producto']);
            
            // Agregarla de nuevo con cascade
            $table->foreign('id_producto')
                  ->references('id_producto')
                  ->on('productos')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('detalle_ventas', function (Blueprint $table) {
            $table->dropForeign(['id_producto']);
            $table->foreign('id_producto')
                  ->references('id_producto')
                  ->on('productos');
        });
    }
};
