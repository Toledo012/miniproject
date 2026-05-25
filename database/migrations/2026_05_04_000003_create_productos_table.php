<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendedor_id')->constrained('users')->restrictOnDelete();
            $table->string('nombre');
            $table->text('descripcion');
            $table->decimal('precio', 10, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();

            $table->index('nombre', 'idx_productos_nombre');
            $table->index('vendedor_id', 'idx_productos_vendedor');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
