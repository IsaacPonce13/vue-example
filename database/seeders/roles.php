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
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Administrador', 'description'=>'Administrador del sistema', 'guard_name'=> 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Usuario', 'description'=> 'Usuario regular del sistema', 'guard_name'=> 'Usr', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Invitado', 'description'=> 'Usuario con privilegios limitados', 'guard_name'=> 'inv', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
