<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comprador_id')
                ->constrained('users')
                ->restrictOnDelete();
            $table->foreignId('producto_id')
                ->constrained('productos')
                ->restrictOnDelete();
            $table->unsignedInteger('cantidad');
            $table->decimal('total', 10, 2);
            $table->string('ticket_ruta', 500)->nullable();
            $table->enum('estado', ['pendiente', 'validada', 'rechazada'])->default('pendiente');
            $table->foreignId('validado_por')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();

            $table->index('comprador_id', 'idx_ventas_comprador');
            $table->index('producto_id', 'idx_ventas_producto');
            $table->index('estado', 'idx_ventas_estado');
            $table->index('validado_por', 'idx_ventas_gerente');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
