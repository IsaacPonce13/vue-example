<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ca_roles')->insert([
            ['id' => 1, 'descripcion' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'descripcion' => 'Usuario', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'descripcion' => 'Invitado', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
