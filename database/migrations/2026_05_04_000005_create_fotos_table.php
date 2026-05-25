<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')
                ->constrained('productos')
                ->cascadeOnDelete();
            $table->string('ruta', 500);
            $table->timestamps();

            $table->index('producto_id', 'idx_fotos_producto');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fotos');
    }
};
