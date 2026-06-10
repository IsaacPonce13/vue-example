<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Mostrar lista de roles
     */
    public function index()
    {
        $roles = Role::with('permissions')->get(); 
        return Inertia::render('roles/index', [ 
            'rol' => $roles 
        ]);
    }

    /**
     * Mostrar formulario para crear rol
     */
    public function create()
    {
        $permisos = Permission::all(); // Obtener todos los permisos
        return Inertia::render('roles/create', [
            'permisos' => $permisos
        ]);
    }

    /**
     * Guardar nuevo rol
     */
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            // 'permisos' => 'required|array|min:1',
            // 'permisos.*' => 'integer|exists:permissions,id',
        ], [
            'name.required' => 'El nombre del rol es requerido',
            'name.unique' => 'Este rol ya existe',
            // 'permisos.required' => 'Debe seleccionar al menos un permiso',
        ]);

        // Crear rol
        $role = Role::create(['name' => $validated['name']]);
        
        // Sincronizar permisos
        // $role->syncPermissions($validated['permisos']);

        return redirect()
            ->route('roles')
            ->with('success', 'Rol creado exitosamente.');
    }

    /**
     * Mostrar formulario para editar rol
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permisos = Permission::all();
        
        return Inertia::render('roles/edit', [
            'rol' => $role,
            'permisos' => $permisos,
        ]);
    }

    /**
     * Actualizar rol
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // Validación (ignorar el rol actual en la regla unique)
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permisos' => 'required|array|min:1',
            // 'permisos.*' => 'integer|exists:permissions,id',
        ], [
            'name.required' => 'El nombre del rol es requerido',
            'name.unique' => 'Este rol ya existe',
            // 'permisos.required' => 'Debe seleccionar al menos un permiso',
        ]);

        // Actualizar rol
        $role->update(['name' => $validated['name']]);
        
        // Sincronizar permisos
        // $role->syncPermissions($validated['permisos']);

        return redirect()
            ->route('roles')
            ->with('success', 'Rol actualizado exitosamente.');
    }

    public function estado(Request $request, $id)
    {
        log::info("Actualizando estado del rol con ID: $id y request data:  ". json_encode($request->all()));
        $role = Role::findOrFail($id);

        $data = $request->validate([
            'active' => 'required|integer|in:0,1',
        ], [], [
            'active' => 'Estado',
        ]);

        try {
            $role->update(['active' => $data['active']]);

            return back()->with('success', 'Estado actualizado exitosamente.');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Error al actualizar el estado: '.$e->getMessage()]);
        }
    }
}