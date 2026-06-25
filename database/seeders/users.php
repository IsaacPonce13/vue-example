<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;

class users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Super2',
            'primer_apellido' => 'usuario2',
            'numero_control' => 12345678,
            'email' => 'iponcericarte13@gmail.com',
            'password' => bcrypt('password'),
            'id_dependencia' => 1,
        ])->assignRole('Super usuario');

        $user = User::create([
            'name' => 'Isaac',
            'primer_apellido' => 'Ponce',
            'numero_control' => 12345679,
            'email' => 'iponcericarte@gmail.com',
            'password' => bcrypt('password'),
            'id_dependencia' => 2,
        ])->assignRole('Administrativo dependencia');

        $role = Role::findOrFail(1);
        $user->syncRoles([$role]);
    }
}
