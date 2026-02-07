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
            $table->string('role', 20)
                  ->default('coordinador')
                  ->after('password');

            $table->foreignId('alumno_id')
                  ->nullable()
                  ->after('role')
                  ->constrained('alumnos')
                  ->nullOnDelete();

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
            $table->dropForeign(['alumno_id']);
            $table->dropForeign(['tutor_id']);

            $table->dropColumn(['tutor_id', 'alumno_id', 'role']);
        });
    }
};
