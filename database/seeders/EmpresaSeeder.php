<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('empresas')->insert([
            [
                'nombre' => 'Tech Solutions S.L.',
                'cif' => 'B12345678',
                'sector' => 'Tecnología',
                'ciudad' => 'Alicante',
                'email_contacto' => 'contacto@techsolutions.com',
                'telefono_contacto' => '965000111',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'SoftEdu S.A.',
                'cif' => 'A87654321',
                'sector' => 'Formación',
                'ciudad' => 'Elche',
                'email_contacto' => 'info@softedu.com',
                'telefono_contacto' => '966111222',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
