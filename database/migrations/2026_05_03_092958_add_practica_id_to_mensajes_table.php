<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mensajes', function (Blueprint $table) {
            $table->foreignId('practica_id')
                ->nullable()
                ->after('destinatario_id')
                ->constrained('practicas')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('mensajes', function (Blueprint $table) {
            $table->dropForeign(['practica_id']);
            $table->dropColumn('practica_id');
        });
    }
};
