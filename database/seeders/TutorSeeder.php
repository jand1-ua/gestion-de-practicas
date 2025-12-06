<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tutores')->insert([
            [
                'empresa_id' => 1,
                'nombre' => 'Carlos Ruiz',
                'email' => 'carlos.ruiz@techsolutions.com',
                'telefono' => '600111222',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'empresa_id' => 2,
                'nombre' => 'Elena Martínez',
                'email' => 'elena.martinez@softedu.com',
                'telefono' => '600333444',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
