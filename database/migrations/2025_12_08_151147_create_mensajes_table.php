<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();

            // Usuario que envía el mensaje
            $table->foreignId('remitente_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Usuario que recibe el mensaje
            $table->foreignId('destinatario_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('asunto');
            $table->text('cuerpo');

            // Campo opcional para marcar como leído
            $table->timestamp('leido_en')->nullable();

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};
