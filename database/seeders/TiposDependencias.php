<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposDependencias extends Seeder
{
    public function run(): void
    {
        DB::table('ca_tipo_dependencia')->insert([
            [
                'id' => 1,
                'descripcion' => 'Secretaria',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'descripcion' => 'Subsecretaria',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'descripcion' => 'Organismo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'descripcion' => 'Organismo autónomo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'descripcion' => 'Municipio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'descripcion' => 'Organismo desconcentrado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'descripcion' => 'H. Congreso del estado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'descripcion' => 'Supremo tribunal de justicia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'descripcion' => 'Gobierno de la república',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
