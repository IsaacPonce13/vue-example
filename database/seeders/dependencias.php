<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class dependencias extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ca_dependencias')->insert(
        [
            'id' => 1,
            'descripcion' => 'icsic',
            'adscripcion' => 'icsic',
            'id_padre' => 0,
            'metadatos' => 'icsic',
            'shortname' => 'icsic',
            // 'tipo_dependencia' => 1,
            'ubicacion' => 'icsic',
            'telefono' => '1234567890',
            'email' => 'icsic@sadas.sdas',
            'horarios' => '10 - 12'
        ]
        );    }
}
