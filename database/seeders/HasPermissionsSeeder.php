<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Definir todos los permisos
        $permissionNames = [
            'modulos',
            'modulos.create',
            'modulos.show',
            'modulos.edit',
            'usuarios',
            'usuarios.create',
            'usuarios.show',
            'usuarios.edit',
            'usuarios.password',
            'usuarios.estado',
            'roles',
            'roles.create',
            'roles.show',
            'roles.edit',
            'roles.password',
            'roles.estado',
            'permisos',
            'permisos.create',
            'permisos.show',
            'permisos.edit',
            'permisos.password',
            'permisos.estado',
            'dependencias',
            'dependencias.create',
            'dependencias.show',
            'dependencias.edit',
            'dependencias.estado',
        ];

        // Crear permisos si no existen
        foreach ($permissionNames as $permissionName) {
            Permission::firstOrCreate(
                ['name' => $permissionName, 'guard_name' => 'web']
            );
        }

        // Obtener todos los permisos
        $allPermissions = Permission::all();

        // Asignar todos los permisos al rol Administrador (ID 1)
        $adminRole = Role::find(1);
        
        if ($adminRole) {
            $adminRole->syncPermissions($allPermissions);
            $this->command->info('Todos los permisos asignados al rol Administrador.');
        } else {
            $this->command->error('No se encontró el rol con ID 1.');
        }
    }
}