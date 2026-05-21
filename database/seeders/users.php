<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => 2, 
            'name' => 'Super2',
            'primer_apellido' => 'usuario2',
            'numero_control' => 12345678,
            'email' => 'iponcericarte13@gmail.com',
            'password' => bcrypt('password'),
            'id_rol' => 1,
            'id_dependencia' => 1,
        ]);
    }
}
