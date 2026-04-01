<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('role', 'users_role_index');
            $table->unique('alumno_id', 'users_alumno_id_unique');
            $table->unique('tutor_id', 'users_tutor_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_alumno_id_unique');
            $table->dropUnique('users_tutor_id_unique');
            $table->dropIndex('users_role_index');
        });
    }
};
