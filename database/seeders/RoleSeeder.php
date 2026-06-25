<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $role1 = Role::create([
            'id' => 1,
            'name' => 'Super usuario',
            'description' => 'Usuario administrador del sistema',
            'guard_name' => 'web',
        ]);
        $role2 = Role::create([
            'id' => 2,
            'name' => 'Administrativo dependencia',
            'description' => 'Administrativo de una dependencia',
            'guard_name' => 'web',
        ]);
        $role3 = Role::create([
            'id' => 3,
            'name' => 'Comunicación social',
            'description' => 'Administrativo de comunicación social',
            'guard_name' => 'web',
        ]);

        // Permisos modulos
        Permission::create(['name' => 'modulos'])->syncRoles([$role1]);
        Permission::create(['name' => 'modulos.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'modulos.show'])->syncRoles([$role1]);
        Permission::create(['name' => 'modulos.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'modulos.store'])->syncRoles([$role1]);
        Permission::create(['name' => 'modulos.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'modulos.estado'])->syncRoles([$role1]);

        // Permisos usuairos
        Permission::create(['name' => 'usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'usuarios.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'usuarios.show'])->syncRoles([$role1]);
        Permission::create(['name' => 'usuarios.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'usuarios.store'])->syncRoles([$role1]);
        Permission::create(['name' => 'usuarios.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'usuarios.password'])->syncRoles([$role1]);
        Permission::create(['name' => 'usuarios.estado'])->syncRoles([$role1]);

        // Permisos Roles
        Permission::create(['name' => 'roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'roles.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'roles.show'])->syncRoles([$role1]);
        Permission::create(['name' => 'roles.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'roles.store'])->syncRoles([$role1]);
        Permission::create(['name' => 'roles.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'roles.estado'])->syncRoles([$role1]);

        // Permisos permisos
        Permission::create(['name' => 'permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'permisos.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'permisos.show'])->syncRoles([$role1]);
        Permission::create(['name' => 'permisos.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'permisos.store'])->syncRoles([$role1]);
        Permission::create(['name' => 'permisos.update'])->syncRoles([$role1]);

    }

}
