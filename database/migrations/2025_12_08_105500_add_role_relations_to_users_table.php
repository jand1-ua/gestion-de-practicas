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
        Schema::table('users', function (Blueprint $table) {
            // Rol del usuario en el sistema: admin, alumno, tutor
            $table->string('role', 20)
                  ->default('coordinador')
                  ->after('password');

            // Relación opcional con alumno
            $table->foreignId('alumno_id')
                  ->nullable()
                  ->after('role')
                  ->constrained('alumnos')
                  ->nullOnDelete();

            // Relación opcional con tutor
            $table->foreignId('tutor_id')
                  ->nullable()
                  ->after('alumno_id')
                  ->constrained('tutores')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Primero quitamos las foreign keys
            $table->dropForeign(['alumno_id']);
            $table->dropForeign(['tutor_id']);

            // Luego las columnas
            $table->dropColumn(['tutor_id', 'alumno_id', 'role']);
        });
    }
};
