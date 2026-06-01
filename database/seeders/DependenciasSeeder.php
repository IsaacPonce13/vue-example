<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DependenciasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ca_dependencias')->insert([
            [
                'id' => 1,
                'descripcion' => 'Departamento TI',
                'adscripcion' => 'General',
                'id_padre' => 0,
                'metadatos' => '{}',
                'shortname' => 'TI',
                'tipo_dependencia' => null,
                'ubicacion' => 'Piso 1',
                'telefono' => '123-456-7890',
                'email' => 'ti@example.com',
                'horarios' => '9:00 AM - 5:00 PM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'descripcion' => 'Recursos Humanos',
                'adscripcion' => 'General',
                'id_padre' => 0,
                'metadatos' => '{}',
                'shortname' => 'HR',
                'tipo_dependencia' => null,
                'ubicacion' => 'Piso 2',
                'telefono' => '123-456-7891',
                'email' => 'hr@example.com',
                'horarios' => '9:00 AM - 5:00 PM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'descripcion' => 'Finanzas',
                'adscripcion' => 'General',
                'id_padre' => 0,
                'metadatos' => '{}',
                'shortname' => 'FIN',
                'tipo_dependencia' => null,
                'ubicacion' => 'Piso 3',
                'telefono' => '123-456-7892',
                'email' => 'finanzas@example.com',
                'horarios' => '9:00 AM - 5:00 PM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
