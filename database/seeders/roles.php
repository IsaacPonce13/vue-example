<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class roles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ca_roles')->insert(
            ['id' => 1, 'descripcion' => 'Super usuario'],
            ['id' => 2, 'descripcion' => 'Comunicación social'],
            ['id' => 3, 'descripcion' => 'Dependencia']
        );
    }
}
