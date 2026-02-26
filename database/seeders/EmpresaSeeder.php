<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empresa::updateOrCreate(
            ['cif' => 'B12345678'],
            [
                'nombre'            => 'Tech Solutions S.L.',
                'sector'            => 'Tecnología',
                'ciudad'            => 'Alicante',
                'email_contacto'    => 'contacto@techsolutions.com',
                'telefono_contacto' => '965000111',
            ]
        );

        Empresa::updateOrCreate(
            ['cif' => 'A87654321'],
            [
                'nombre'            => 'SoftEdu S.A.',
                'sector'            => 'Formación',
                'ciudad'            => 'Elche',
                'email_contacto'    => 'info@softedu.com',
                'telefono_contacto' => '966111222',
            ]
        );

        Empresa::factory(8)->create();
    }
}
