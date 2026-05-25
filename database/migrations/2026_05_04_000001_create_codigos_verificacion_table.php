<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('codigos_verificacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('codigo');
            $table->dateTime('expiracion');
            $table->timestamps();

            $table->index('usuario_id', 'idx_codigos_usuario');
            $table->index('expiracion', 'idx_codigos_expiracion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('codigos_verificacion');
    }
};
