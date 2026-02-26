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
        Schema::create('practicas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('alumno_id')
                  ->constrained('alumnos')
                  ->restrictOnDelete();

            $table->foreignId('empresa_id')
                  ->constrained('empresas')
                  ->restrictOnDelete();

            $table->foreignId('tutor_id')
                  ->constrained('tutores')
                  ->restrictOnDelete();

            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();

            $table->string('estado', 20)->default('pendiente'); 
            $table->text('observaciones')->nullable();

            
            $table->index(['estado', 'empresa_id']);
            $table->index(['alumno_id', 'estado']);
            $table->index('fecha_inicio');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practicas');
    }
};
